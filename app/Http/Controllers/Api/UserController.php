<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function id($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }

    
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if (!isset($data['id'])) {
            $object = [
                "response" => "Error: se requiere el campo 'id' para actualizar el registro.",
            ];
            return response()->json($object);
        }

        $user = User::find($data['id']);

        if($user) {
            $user->name = $data['name'];
            $user->email = $data['email'];

            if ($user->save()) {
                $object = [
                    "response" => "Éxito: registro modificado correctamente.",
                    "data" => $user,
                ];
                return response()->json($object);
            } else {
                $object = [
                    "response" => "Error: algo salió mal, por favor inténtalo de nuevo.",
                ];
                return response()->json($object);
            }
        } else {
            $object = [
                "response" => "Error: registro no encontrado.",
            ];
            return response()->json($object);
        }
    }

}
