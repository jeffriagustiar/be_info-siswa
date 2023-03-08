<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function all(Request $request)
    {
        $nis = $request->input('nis');
        if ($nis) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => Siswa::find($nis)
            ]);
        }else{
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => Siswa::all()
            ]);
        }

        
    }
}
