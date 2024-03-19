<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Game; // Agregamos la importación de la clase Game

class LikeController extends Controller
{
    public function list()
    {
        $likes = Like::all();
        return response()->json($likes);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'game_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $like = Like::where('game_id', $data['game_id'])
                    ->where('user_id', $data['user_id'])
                    ->first();

        if ($like) {
            // El usuario ya le dio like al juego, eliminar el like
            $like->delete();
            $game = Game::findOrFail($data['game_id']);
            $game->decrement('likes'); // Decrementar el contador de likes
        } else {
            // El usuario aún no ha dado like al juego, crear un nuevo like
            $like = Like::create([
                'game_id' => $data['game_id'],
                'user_id' => $data['user_id'],
            ]);
            $game = Game::findOrFail($data['game_id']);
            $game->increment('likes'); // Incrementar el contador de likes
        }

        return response()->json(['message' => 'Like actualizado correctamente']);
    }
}
