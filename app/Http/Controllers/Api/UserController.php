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
            'id' => 'required|integer|min:1',
            'name' => 'required|min:3|max:30',
            'email' => 'required|email|min:3|max:30',
        ]);

        $user = User::find($data['id']);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'data' => $user]);
    }
}
