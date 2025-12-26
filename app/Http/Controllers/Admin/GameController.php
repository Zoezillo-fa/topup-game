<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('admin.games.index', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:games,code',
            'publisher' => 'required',
            'target_endpoint' => 'required', // ml, ff, dll
        ]);

        // Simpan data (Logic upload gambar bisa ditambahkan nanti, sementara text dulu sesuai seeder)
        Game::create($request->all());

        return back()->with('success', 'Game berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->update($request->all());
        return back()->with('success', 'Game berhasil diupdate!');
    }

    public function destroy($id)
    {
        Game::findOrFail($id)->delete();
        return back()->with('success', 'Game dihapus!');
    }
}