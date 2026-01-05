<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Game;
use App\Models\Product;
use App\Models\User;
use App\Services\DigiflazzService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk DB Transaction

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi (Monitoring)
     */
    public function index()
    {
        // Ambil data transaksi, urutkan dari yang terbaru (latest)
        $transactions = Transaction::latest()->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Update status transaksi manual (Fitur Darurat via list index)
     */
    public function update(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required'
        ]);

        // Cari transaksi dan update
        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'status' => $request->status,
            // Jika status diubah jadi FAILED, kita juga update processing_status biar sinkron
            'processing_status' => ($request->status == 'FAILED') ? 'FAILED' : $transaction->processing_status
        ]);

        return back()->with('success', 'Status transaksi berhasil diperbarui manual.');
    }

    /**
     * Form untuk membuat transaksi manual
     */
    public function create()
    {
        $games = Game::orderBy('name')->get();
        // Ambil user limit 100 agar query tidak berat
        $users = User::where('role', 'member')->latest()->limit(100)->get();
        
        return view('admin.transactions.create', compact('games', 'users'));
    }

    /**
     * Proses penyimpanan transaksi manual
     */
    public function store(Request $request)
    {
        // 1. Cek Mode (Database atau Manual?)
        if ($request->has('is_manual_input')) {
            // Validasi Input Manual
            $request->validate([
                'manual_sku'   => 'required|string',
                'manual_price' => 'required|numeric',
                'manual_name'  => 'required|string',
                'user_id_game' => 'required|string',
                'status'       => 'required',
            ]);

            // Set Data Variabel Manual
            $sku = $request->manual_sku;
            $gameCode = 'MANUAL'; // Kode Game Default untuk manual
            $productName = $request->manual_name;
            $price = $request->manual_price;

        } else {
            // Validasi Input Database (Logika Lama)
            $request->validate([
                'product_code' => 'required|exists:products,code',
                'user_id_game' => 'required|string',
                'status'       => 'required',
            ]);

            // Ambil Data dari Database
            $product = Product::where('code', $request->product_code)->first();
            $sku = $product->code;
            $gameCode = $product->game_code;
            $productName = $product->name;
            $price = $product->price;
        }

        try {
            DB::beginTransaction();

            // 2. Simpan Transaksi
            $transaction = new Transaction();
            $transaction->reference = 'TRX-' . strtoupper(Str::random(10));
            $transaction->user_id = $request->user_id; 
            $transaction->product_code = $sku; // SKU ini yang akan dikirim ke Digiflazz
            $transaction->game_code = $gameCode; 
            $transaction->user_id_game = $request->user_id_game;
            $transaction->amount = $price; 
            $transaction->status = $request->status; 
            $transaction->processing_status = 'PENDING';
            
            // Simpan nama produk sebagai history (jika kolom ada)
            // $transaction->note = $productName; 

            $transaction->save();

            DB::commit();

            // 3. Proses ke Digiflazz (Jika dicentang & Status PAID)
            if ($request->has('process_provider') && $request->status == 'PAID') {
                $service = new DigiflazzService();
                // DigiflazzService akan menggunakan $transaction->product_code (SKU)
                $service->processTransaction($transaction);
            }

            return redirect()->route('admin.transactions.index')
                ->with('success', "Transaksi berhasil dibuat! SKU: $sku");

        } catch (\Exception $e) {
            DB::rollBack();
            // Cek error foreign key (Jika database mewajibkan product_code ada di tabel products)
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                return back()->with('error', 'Gagal: SKU Manual tidak ditemukan di database lokal, dan database Anda menolak SKU asing. Harap buat produk dummy di database terlebih dahulu dengan kode tersebut.');
            }
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}