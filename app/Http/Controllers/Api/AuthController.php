<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required',
            'password' => 'required',
            'username' => 'required|max:55',
            'platform_id' => 'required'
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;

        $notif = Notification::create([
            'owner_id' => $user['id'],
            'message' => 'NEW_USER_REGISTER',
            'status' => 1
        ]);

        return response(['profile' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response([
                'response' => 'Invalid Credentials',
                'message' => 'error'
            ]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'profile' => auth()->user(),
            'userId' => auth()->user()->id,
            'access_token' => $accessToken,
            'message' => 'success'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;
        $profile = Profile::where('user_id', $userId)->first();

        return response()->json(['user' => $user, 'profile' => $profile]);
    }


   
public function getUserData(Request $request)
{
    $user = $request->user();
    return response()->json($user);
}



}
