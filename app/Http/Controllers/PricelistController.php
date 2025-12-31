<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class PricelistController extends Controller
{
    public function index()
    {
        // Ambil semua Game beserta Produknya
        // Produk diurutkan dari harga termurah
        $games = Game::with(['products' => function($query) {
            $query->where('is_active', true)->orderBy('price', 'asc');
        }])->get();

        return view('pricelist', compact('games'));
    }
}