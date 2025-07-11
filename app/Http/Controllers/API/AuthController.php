<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $req->validate([
            'name'=>'required|string|min:1|max:10',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:6|confirmed',
            // Password::min(8)
            // ->mixedCase()
            // ->letters()
            // ->numbers()
            // ->symbols()
            // ],
        ]);

        $user=User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>bcrypt($req->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
        
    }

    public function login(Request $req)
    {
        

        $req->validate([
        'email' => 'required|email',
        'password' => 'required',
        ]);

        $user=User::where('email',$req ->email)->first();

        if(!$user || !Hash::check($req->password,$user->password))
        {
            throw ValidationException::withMessages([
                'email'=>['Invalid credentials !'],
            ]);
        }

        return response()->json([
            'token'=>$user->createToken('api-token')->plainTextToken
        ]);
    }
}

