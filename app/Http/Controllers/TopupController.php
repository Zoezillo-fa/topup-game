<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Product;
use App\Models\Promo;     
use App\Models\Configuration;
use App\Models\PaymentMethod;
use App\Models\Transaction; 
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    /**
     * 1. MENAMPILKAN HALAMAN FORM ORDER
     */
    public function index($slug)
    {
        // Cari game berdasarkan slug dan pastikan aktif
        $game = Game::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        
        // Ambil Produk berdasarkan 'game_code'
        $products = Product::where('game_code', $game->code) 
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc')
                            ->get();

        // Ambil Semua Metode Pembayaran Aktif
        $payments = PaymentMethod::where('is_active', 1)->get();

        // [PENTING] Grouping Pembayaran agar sesuai dengan Accordion di View Frontend
        $paymentChannels = [
            'e_wallet'        => $payments->where('type', 'e_wallet'),
            'virtual_account' => $payments->where('type', 'virtual_account'),
            'retail'          => $payments->where('type', 'retail'),
        ];
        
        // Kirim data ke View (Perhatikan variabel paymentChannels)
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    /**
     * 2. LOGIKA CEK ID GAME (API EXTERNAL)
     */
    public function checkGameId(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'game_code' => 'required' 
        ]);

        $id = $request->user_id;
        $zone = $request->zone_id;
        $gameSlug = $request->game_code; 

        // Cari endpoint di DB
        $game = Game::where('slug', $gameSlug)->first();
        $endpoint = ($game && !empty($game->endpoint)) ? $game->endpoint : $gameSlug;

        // URL API Cek ID (Isan API)
        $url = "https://api.isan.eu.org/nickname/{$endpoint}?id={$id}";
        if (!empty($zone)) {
            $url .= "&server={$zone}";
        }

        try {
            $response = Http::timeout(5)->get($url);
            $data = $response->json();

            if (isset($data['success']) && $data['success'] == true && !empty($data['name'])) {
                return response()->json([
                    'status' => 'success',
                    'nick_name' => $data['name'], 
                    'data' => ['user_id' => $id, 'zone_id' => $zone]
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'ID tidak ditemukan.'
                ]);
            }
        } catch (\Exception $e) {
            // Fallback jika API Error
            return response()->json([
                'status' => 'success',
                'nick_name' => 'Player Found (Server Busy)',
                'is_fallback' => true
            ]);
        }
    }

    /**
     * 3. PROSES ORDER (CHECKOUT KE TRIPAY)
     */
    public function process(Request $request)
    {
        // A. Validasi Input
        $request->validate([
            'user_id' => 'required|string',
            'product_code' => 'required|exists:products,code',
            'payment_method' => 'required|exists:payment_methods,code',
        ]);

        // B. Ambil Data Produk & Payment
        $product = Product::where('code', $request->product_code)->first();
        $payment = PaymentMethod::where('code', $request->payment_method)->first();

        // Tentukan Harga Dasar (Normal / VIP)
        $basePrice = (Auth::check() && $product->price_vip > 0) ? $product->price_vip : $product->price;

        // C. Cek Harga Modal Real-time (Digiflazz Safeguard)
        $realTimeCost = $this->checkRealTimePrice($product->sku_provider);
        if ($realTimeCost !== false && $realTimeCost > $basePrice) {
            $product->update(['cost_price' => $realTimeCost]); 
            return back()->with('error', 'Harga produk berubah dari pusat. Silakan refresh halaman.');
        }

        // D. Hitung Promo
        $discountAmount = 0;
        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo && $promo->is_active) {
                $discountAmount = ($promo->type == 'percent') ? $basePrice * ($promo->value / 100) : $promo->value;
            }
        }

        // E. Hitung Total Bayar
        $adminFee = $payment->flat_fee + ($basePrice * $payment->percent_fee / 100);
        $finalPrice = ceil($basePrice - $discountAmount + $adminFee);
        
        // Buat Invoice Unik
        $invoice = 'TRX-' . strtoupper(Str::random(6)) . rand(100,999);

        // F. REQUEST KE TRIPAY (OPEN TRANSACTION)
        $tripayPayload = $this->requestTripayTransaction(
            $payment->code, 
            $invoice, 
            $finalPrice, 
            $product->name, 
            $request->user_id,
            Auth::user()
        );

        if (!$tripayPayload['success']) {
            return back()->with('error', 'Gagal membuat pembayaran: ' . $tripayPayload['message']);
        }

        $tripayData = $tripayPayload['data'];

        // G. Simpan Transaksi ke Database
        $trx = Transaction::create([
            'invoice' => $invoice,
            'user_id' => Auth::id() ?? null,
            'game_code' => $product->game_code,
            'product_code' => $product->code,
            'target_id' => $request->user_id,
            'zone_id' => $request->zone_id,
            'nickname' => $request->nickname_game ?? '-',
            
            'amount' => $finalPrice, // Harga yang harus dibayar user
            'payment_method' => $payment->code,
            
            // Simpan Data dari Tripay
            'tripay_reference' => $tripayData['reference'],
            'pay_code' => $tripayData['pay_code'] ?? null, // Kode Bayar / No VA
            'checkout_url' => $tripayData['checkout_url'] ?? null, // Link QRIS
            
            'status' => 'Unpaid', // Status awal Unpaid
            'note' => 'Menunggu Pembayaran'
        ]);

        // H. Redirect ke Halaman Invoice
        return redirect()->route('order.check', ['invoice' => $invoice])
                         ->with('success', 'Order berhasil! Silakan lakukan pembayaran.');
    }

    /**
     * HELPER: REQUEST TRANSAKSI KE TRIPAY
     */
    private function requestTripayTransaction($method, $invoice, $amount, $productName, $buyerPhone, $user = null)
    {
        $apiKey       = Configuration::getBy('tripay_api_key');
        $privateKey   = Configuration::getBy('tripay_private_key');
        $merchantCode = Configuration::getBy('tripay_merchant_code');
        $mode         = Configuration::getBy('tripay_mode') ?? 'production'; // sandbox / production

        $baseUrl = ($mode == 'sandbox') ? 'https://tripay.co.id/api-sandbox/transaction/create' : 'https://tripay.co.id/api/transaction/create';

        // Buat Signature
        $signature = hash_hmac('sha256', $merchantCode . $invoice . $amount, $privateKey);

        $data = [
            'method'         => $method,
            'merchant_ref'   => $invoice,
            'amount'         => $amount,
            'customer_name'  => $user->name ?? 'Guest User',
            'customer_email' => $user->email ?? 'guest@example.com',
            'customer_phone' => '08123456789', // Sebaiknya ambil dari input form jika ada
            'order_items'    => [
                [
                    'sku'      => 'PROD-01',
                    'name'     => $productName,
                    'price'    => $amount,
                    'quantity' => 1
                ]
            ],
            'return_url'   => route('order.check', ['invoice' => $invoice]),
            'expired_time' => (time() + (24 * 60 * 60)), // Expired 24 Jam
            'signature'    => $signature
        ];

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post($baseUrl, $data);
            $result = $response->json();

            if ($result['success']) {
                return ['success' => true, 'data' => $result['data']];
            } else {
                return ['success' => false, 'message' => $result['message']];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * HELPER: Cek Harga Modal Real-Time Digiflazz
     */
    private function checkRealTimePrice($sku)
    {
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        
        if (!$username || !$key || !$sku) return false;

        $sign = md5($username . $key . "pricelist");

        try {
            $response = Http::timeout(3)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign
            ]);
            
            $result = $response->json();

            if (isset($result['data']) && is_array($result['data'])) {
                $item = collect($result['data'])->firstWhere('buyer_sku_code', $sku);
                if ($item) {
                    // Jika gangguan, naikkan harga biar tidak bisa dibeli
                    if (!$item['buyer_product_status'] || !$item['seller_product_status']) {
                        return 999999999; 
                    }
                    return $item['price'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Digiflazz Error: " . $e->getMessage());
            return false;
        }
        return false;
    }
}