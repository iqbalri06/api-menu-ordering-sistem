<?php

namespace App\Http\Controllers\Modules\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Role;

class UserController extends Controller
{
    use ValidatesRequests;

    
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            $credentials = $request->only('email', 'password');
            
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Email atau password salah'
                ], 401);
            }

            $user = Auth::user();

            return response()->json([
                'status' => 100,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60 // Convert minutes to seconds
                ]
            ], 200);

        } catch (\Exception $err) {
            return response()->json([
                'status' => 2000,
                'message' => $err->getMessage()
            ], 500);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role_id' => 'required|exists:role,id',
                'status' => 'required|boolean'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'status' => $request->status,
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => 100,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60
                ]
            ], 201);

        } catch (\Exception $err) {
            return $this->appResponse(2000, $err->getMessage());
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            
            return response()->json([
                'status' => 100,
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status' => 2000,
                'message' => $err->getMessage()
            ], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            
            return response()->json([
                'status' => 100,
                'data' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60
                ]
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status' => 2000,
                'message' => $err->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $data = User::all();
            return $this->appResponse(100, $data);
        } catch (\Exception $err) {
            return $this->appResponse(2000, $err->getMessage());
        }
    }

    
}