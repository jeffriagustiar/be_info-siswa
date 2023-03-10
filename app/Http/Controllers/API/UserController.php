<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string']
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => md5($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Someting went wrong',
                'error' => $error,
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'nis' => 'required',
                'pinsiswa' => 'required'
            ]);

            $user = User::with(['kelas'])->where('nis', $request->nis)->first();
            if ( $request->pinsiswa != $user->pinsiswa) {
                throw new \Exception('Invalid Credentials');
            }
            $token = Str::random(100);

            $user->api_token = $token;
            $user->save();

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error,
            ]);
        }
    }

    public function fetch(Request $request)
    {
        return response()->json([
            $request->user(),
            'Data profile user berhasil diambil'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return response()->json([
            'data' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $token = User::where('nis', $request->nis)->first();
        $token->api_token ='';
        $token->save();

        return response()->json([$token ,'Token Revoked']);
    }
}
