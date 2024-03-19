<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Carbon\Carbon;


class CommentsController extends Controller
{
    public function comments()
    {
        $comments = Comment::all();
        $List = [];

        foreach ($comments as $comment) {
            $objectc = [
                'id' => $comment->id,
                'id_game' => $comment->id_game,
                'User' => $comment->User->name,
                'comment' => $comment->comment,
                'datetime' => $comment->datetime,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
            ];
            array_push($List, $objectc);
        }

        return response()->json($List);
    }

    public function commentId($id)
    {
        $comment = Comment::where('id', $id)->first();
        $object = null;

        if ($comment) {
            $object = [
                "id" => $comment->id,
                'id_game' => $comment->id_game,
                "id_user" => $comment->id_user,
                "comment" => $comment->comment,
                "datetime" => $comment->datetime,
                "created_at" => $comment->created_at,
                "updated_at" => $comment->updated_at,
            ];
        }

        return response()->json($object);
    }

    public function getCommentsByGameId($id_game)
    {
        $comments = Comment::where('id_game', $id_game)->get();
        return response()->json($comments);
    }

    public function createComment(Request $request)
    {
        $request->validate([
            'id_game' => 'required|integer',
            'id_user' => 'required|integer',
            'comment' => 'required|string',
            // Aquí puedes agregar más validaciones según tus requisitos
        ]);

        $comment = Comment::create([
            'id_game' => $request->id_game,
            'id_user' => $request->id_user,
            'comment' => $request->comment,
            'datetime' => Carbon::now(),
            // Si necesitas establecer la fecha y hora actual, puedes hacerlo aquí
        ]);

        return response()->json($comment, 201);
    }
}
