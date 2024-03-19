<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game; 

class GameController extends Controller
{
    public function game()
    {
        $games = Game::all();
        $list = [];

        foreach ($games as $game) {
            $object = [
                "id" => $game->id,
                "category" => $game->category->Genere,
                "name" => $game->games,
                "photo" => $game->photo,
                "synopsis" => $game->synopses,
                "review" => $game->review,
                "likes" => $game->likes,
                "created_at" => $game->created_at,
                "updated_at" => $game->updated_at,
            ];
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function gameid($id)
    {
        $game = Game::where('id', '=', $id)->first();
        $object = null;

        if ($game) {
            $object = [
                "id" => $game->id,
                "id_category" => $game->id_categori,
                "game_name" => $game->games,
                "photo" => $game->photo,
                "synopsis" => $game->synopses,
                "review" => $game->review,
                "likes" => $game->likes,
                "created_at" => $game->created_at,
                "updated_at" => $game->updated_at,
            ];
        }

        return response()->json($object);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'id_category' => 'required|integer',
            'games' => 'required|string',
            'photo' => 'required|string',
            'synopses' => 'required|string',
            'review' => 'required|string',
            'likes' => 'required|integer',
            
        ]);

        // Creamos el juego
        $game = Game::create([
            'id_categori' => $data['id_category'],
            'games' => $data['games'],
            'photo' => $data['photo'],
            'synopses' => $data['synopses'],
            'review' => $data['review'],
            'likes' => $data['likes'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($game) {
            $response = [
                'message' => 'Game created successfully',
                'data' => $game,
                'likes' => $game->likes, // Agregamos el campo likes al objeto de respuesta
            ];
            return response()->json($response);
        } else {
            return response()->json([
                'message' => 'Error creating game',
            ], 500); // Status code 500 for server error
        }
    }



    public function deleteGame($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404); // Not Found
        }

        if ($game->delete()) {
            return response()->json(['message' => 'Game deleted successfully'], 200); // OK
        } else {
            return response()->json(['message' => 'Failed to delete game'], 500); // Internal Server Error
        }

    }



}
