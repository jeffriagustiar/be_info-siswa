<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Ctt_Siswa;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dataSiswa()
    {
        $result = DB::select("SELECT a.nis,a.nama,b.kelas FROM siswa a inner join kelas b on a.idkelas=b.replid WHERE a.aktif=1 ORDER BY a.nama ASC");

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $result,
        ]);
    }

    public function dataKategori(Request $request)
    {
        $jenis = $request->input('jenis');//pelanggaran

        $result = DB::select("select replid,nama_kategori,kategori from ctt_kategori where kategori='$jenis'");

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $result,
        ]);
    }

    public function dataJenis(Request $request)
    {
        $kategori = $request->input('kategori');//1

        $result = DB::select("SELECT replid,nama_ctt,point FROM ctt_baik_buruk WHERE id_kategori='$kategori'");

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $result,
        ]);
    }

    public function laporkanSiswa(Request $request)
    {
        try {
            $request->validate([
                'id_ctt' => 'required',
                'nis' => 'required',
                'ket' => 'required',
                'point' => 'required'
            ]);

            $id = $request->id_ctt;
            $nis = $request->nis;
            $ket = $request->ket;
            $point = $request->point;
            $nip = Auth::user()->login;

            $data = Ctt_Siswa::create([
                'id_ctt' => $id,
                'nis' => $nis,
                'nip' => $nip,
                'ket' => $ket,
                'point' => $point
            ]);

            return response()->json([
                'code' => 200,
                'pesan' => 'Berhasil buat laporan',
                'id' => $id,
                'nis' => $nis,
                'ket' => $ket,
                'point' => $point,
                'nip' => $nip,
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error,
            ]);
        }
    }

    public function listLaporan()
    {
        $nip = Auth::user()->login;

        $result = DB::select("
        SELECT 
            a.replid,b.nama,e.nama_kategori as kategori,d.nama_ctt as jenis,c.kelas,a.point,a.acc,a.ket,a.nip,a.tanggal
        FROM 
            ctt_siswa a 
            inner join siswa b on a.nis=b.nis
            inner join kelas c on b.idkelas=c.replid
            inner join ctt_baik_buruk d on a.id_ctt=d.replid
            inner join ctt_kategori e on d.id_kategori=e.replid
        WHERE
            a.nip='$nip'
        ORDER BY
            a.replid DESC"
        );

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $result,
        ]);
    }


    public function validasiLaporan(Request $request)
    {
        $id=$request->input('id');

        $data = Ctt_Siswa::where('replid',$id);

        $result=$data->update([
            'acc' => $request->acc
        ]);
        return response()->json([
            'data' => $result,
            'data' => $data->get()
        ]);
    }

}
