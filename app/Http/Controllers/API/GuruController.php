<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
}
