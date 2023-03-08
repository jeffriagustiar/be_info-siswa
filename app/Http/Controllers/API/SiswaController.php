<?php

namespace App\Http\Controllers\API;

use App\Models\Spp;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PenerimaanSpp;
use Illuminate\Support\Facades\Auth;

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
                'data' => Siswa::limit(50)->get()
            ]);
        }

        
    }

    public function sppSiswa(Request $request)
    {
        $spp = Spp::where('nis','21220002')->first();
        $a = $spp->besar;
        $b = PenerimaanSpp::where('idbesarjtt',$spp->replid)->sum('jumlah');
        $c = $a - $b;
        $d = number_format(($b/$a), 2,);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => [
                "besar" => $a,
                "dibayar" => $b,
                "sisa" => $c,
                "persen" => $d,
            ],
            'test' => Auth::user()->nis
        ]);
    }
}
