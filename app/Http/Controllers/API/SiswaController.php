<?php

namespace App\Http\Controllers\API;

use App\Models\Spp;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AturannhbModel;
use App\Models\KomenRaporModel;
use App\Models\NapModel;
use App\Models\PelajaranModel;
use App\Models\PenerimaanSpp;
use App\Models\PhsiswaModel;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Double;

class SiswaController extends Controller
{
    public function all(Request $request)
    {
        $nis = $request->input('nis');
        if ($nis) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => Siswa::with(['kelas'])->find($nis)
            ]);
        }else{
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => Siswa::with(['kelas'])->limit(50)->get()
            ]);
        }

        
    }

    public function sppSiswa(Request $request)
    {
        $nis = Auth::user()->nis;
        $spp = Spp::where('nis',$nis)->first();
        if ($spp) {
            $a = $spp->besar;
            $b = PenerimaanSpp::where('idbesarjtt',$spp->replid)->sum('jumlah');
            $c = $a - $b;
            $d = number_format(($b/$a), 2,);
            $e = ($b/$a)*100;
        } else {
            $a = '0';
            $b = '0';
            $c = 0;
            $d = '0.0';
            $e = '0';
        }
        

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => [
                "besar" => $a,
                "dibayar" => $b,
                "sisa" => $c,
                "persen" => $d,
                "persen2" => $e,
            ],
            'test' => $nis
        ]);
    }

    public function sppDetail(Request $request)
    {
        $nis = Auth::user()->nis;
        $spp = Spp::where('nis',$nis)->first();
        if ($spp) {
            $data = PenerimaanSpp::where('idbesarjtt',$spp->replid)->get();
        } else {
            $data = [];
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function nilaiRapor(Request $request)
    {
        $data = NapModel::join('siswa', 'nap.nis','=','siswa.nis')
                        ->join('komenrapor', 'nap.idinfo', '=', 'komenrapor.replid')
                        ->join('aturannhb', 'nap.idaturan', '=', 'aturannhb.replid')
                        ->join('pelajaran', 'nap.idpelajaran', '=', 'pelajaran.replid')
                        ->select(
                            'siswa.nama',
                            'nap.idpelajaran',
                            'pelajaran.nama',
                            'nap.nilaiangka',
                            'nap.nilaihuruf',
                            'komenrapor.idsemester',
                            'aturannhb.dasarpenilaian',
                            'nap.komentar',
                            'komenrapor.komentar as komentar2',
                        )
                        ->where('nap.nis','=',Auth::user()->nis)
                        ->where('komenrapor.idsemester','=',$request->input('id'))
                        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function pHarianSiswa(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $data = PhsiswaModel::where('nis','=',Auth::user()->nis)
                            ->whereYear('ts','=',$year);
        if ($month) {
            $data->WhereMonth('ts','=',$month);
        }
                            
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data->get(),
        ]);
    }
}
