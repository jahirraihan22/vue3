<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registered successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // check mail
        $user = User::where('email',$fields['email'])->first();

        // check password
        if(!$user || !Hash::check($fields['password'],$user->password)){
            return response()->json([
                'status' => 'success',
                'message' => 'User not found',
            ]);
        }

        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged Out successfully',
        ]);
    }
}
