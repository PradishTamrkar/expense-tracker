<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //Register user
    public function register(Request $request){

            $validated= $request->validate([
                'name'=>'required|string|max:255',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']), //password hashing
            ]);
            
            //create token
            $token= $user->createToken('auth_token')->plainTextToken;

            return response([
                'success'=>true,
                'message'=>'User created successfully',
                'user'=>$user,
                'token'=>$token,
                'token_type'=>'Bearer',
            ],201);
    }

    //user login
    public function login(Request $request){
        try{
            $validated=$request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            //find user by email
            $user = User::where('email',$validated['email'])->first();

            //check if user exists and pw is correct
            if(!$user || !Hash::check($validated['password'], $user->password)){
                return response()->json([
                    'success'=>false,
                    'message'=>'Invalid credentials'
                ],401);
            }

            // //to delete old token 
            // $user->tokens()->delete();

            //create new token on each login
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
        }catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    //revoke token when logged out
    public function logout(Request $request)
    {
        //delete current token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Logged out successfully'
        ]);
    }

    //get authenticated user /api/user
    public function user(Request $request){
        return response()->json([
            'success'=>true,
            'user'=>$request->user()
        ]);
    }
}
