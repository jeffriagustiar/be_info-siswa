<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Guru\UserGuruModel;
use App\Http\Controllers\Controller;
use App\Models\Guru\ApiTokenGuruModel;
use App\Models\Guru\ProfileModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller
{
    // belum dipakai
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

    // login siswa
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

    // ambil data siswa
    //? belum dipakai
    public function fetch(Request $request)
    {
        return response()->json([
            $request->user(),
            'Data profile user berhasil diambil'
        ]);
    }

    // update data siswa
    //? belum dipakai
    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return response()->json([
            'data' => $user
        ]);
    }

    //logout siswa
    public function logout(Request $request)
    {
        $token = User::where('nis', $request->nis)->first();
        $token->api_token ='';
        $token->save();

        return response()->json([$token ,'Token Revoked']);
    }


    //GURU
    //? untuk pengolahan data guru

    //login guru
    public function loginGuru(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'required',
                'password' => 'required'
            ]);

            $user = UserGuruModel::where('login', $request->nip)->first();
            
            if ( md5($request->password) != $user->password) {
                throw new \Exception('Invalid Credentials');
            }
            $token = Str::random(100);

            $dataGuru = ProfileModel::where('nip',$request->nip)->first();

            $user->api_token = $token;
            $user->save();

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'nama' => $dataGuru->nama,
                'kelamin' => $dataGuru->kelamin,
                'user' => $user,
                // 'a' => $apiGuru->get()
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error,
            ]);
        }
    }

    //logout guru
    public function logoutGuru(Request $request)
    {
        $token = UserGuruModel::where('login', $request->nip)->first();
        $token->api_token ='';
        $token->save();

        return response()->json(['Token Revoked']);
    }

    //ambil data guru
    public function dataGUru()
    {
        $result = ProfileModel::where('nip',Auth::user()->login)->first();
        $kelola = Auth::user()->kelola;
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'kelola' => $kelola,
            'data' => $result,
        ]);
    }
}
