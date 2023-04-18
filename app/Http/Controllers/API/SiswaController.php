<?php

namespace App\Http\Controllers\API;

use App\Models\Spp;
use App\Models\Siswa;
use App\Models\NapModel;
use App\Models\PhsiswaModel;
use Illuminate\Http\Request;
use App\Models\PenerimaanSpp;
use App\Models\AturannhbModel;
use App\Models\PelajaranModel;
use App\Models\KomenRaporModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SemesterModel;
use App\Models\TahunModel;
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
                        ->orderBy("pelajaran.nama", "asc")
                        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function nilaiRaporD(Request $request)
    {
        $nis = Auth::user()->nis;
        $sem = $request->input('sem');
        $jenis = $request->input('jenis'); //KMK
        $tipe = $request->input('tipe'); //ASSOF
        $tahun = $request->input('tahun'); //2022/2023
        $data2 = DB::select(" 
            SELECT 
                d.nama,a.idaturan,b.nama,a.nilaiangka,a.nilaihuruf,a.idinfo,c.replid,c.idsemester,e.dasarpenilaian,c.komentar,c.jenis,f.kode,f.kelompok, g.nilaimin, i.tahunajaran
            FROM 
                nap a 
                inner join pelajaran b on a.idpelajaran=b.replid 
                inner join komenrapor c on a.idinfo=c.replid 
                inner join siswa d on a.nis=d.nis 
                inner join aturannhb e on a.idaturan=e.replid 
                inner join kelompokpelajaran f on b.idkelompok=f.replid
            
                inner join infonap g on a.idinfo=g.replid
                inner join kelas h on g.idkelas=h.replid
                inner join tahunajaran i on h.idtahunajaran=i.replid
            
            where 
                d.nis='$nis'and 
                g.idsemester='$sem' and 
                f.kode='$jenis' and 
                e.dasarpenilaian like '%$tipe%' and 
                i.tahunajaran='$tahun'
        ");
        $data = DB::select("
            SELECT 
                a.idpelajaran,b.nama,a.nilaiangka,a.nilaihuruf,c.idsemester,e.dasarpenilaian,a.komentar,c.komentar as komentar2,
                f.kode,f.kelompok,h.tahunajaran
            FROM 
                nap a 
                inner join pelajaran b on a.idpelajaran=b.replid 
                inner join komenrapor c on a.idinfo=c.replid 
                inner join siswa d on a.nis=d.nis 
                inner join aturannhb e on a.idaturan=e.replid 
                inner join kelompokpelajaran f on b.idkelompok=f.replid
                inner join kelas g on d.idkelas=g.replid
                inner join tahunajaran h on g.idtahunajaran=h.replid

            where 
                d.nis='$nis' 
                and c.idsemester='$sem' 
                and f.kode='$jenis' 
                and e.dasarpenilaian like '%$tipe%' 
                and h.tahunajaran='$tahun'
        ");
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data2,
        ]);
    }

    public function nilaiRaporPancasila(Request $request)
    {
        $nis = Auth::user()->nis;
        $sem = $request->input('sem');
        $jenis = 'P5';
        $tipe = 'D';
        $tahun = $request->input('tahun'); //2022/2023
        $mapel = $request->input('mapel'); //136
        $data2 = DB::select(" 
            SELECT 
                d.nama,a.idaturan,b.nama,a.nilaiangka,
                CASE a.nilaihuruf
                    WHEN 'SB' THEN 'Sangat Berkembang'
                    WHEN 'BSH' THEN 'Berkembang Sesuai Harapan'
                    WHEN 'MB' THEN 'Mulai Berkembang'
                    WHEN 'BB' THEN 'Belum Berkembang'
                    ELSE a.nilaihuruf
                END as nilaihuruf,
                a.idinfo,c.replid,c.idsemester,
                CASE e.dasarpenilaian 
                    WHEN 'D1' THEN 'D1 : Beriaman, bertaqwa kepada Tuhan YME dan berakhlak mulia'
                    WHEN 'D2' THEN 'D2 : Bernalar kritis'
                    WHEN 'D3' THEN 'D3 : Mandiri'
                    WHEN 'D4' THEN 'D4 : Kebhinekaan Global'
                    WHEN 'D5' THEN 'D5 : Kreatif'
                    WHEN 'D6' THEN 'D6 : Bergotongroyong'
                    ELSE e.dasarpenilaian
                END AS dasarpenilaian,
                c.komentar,c.jenis,f.kode,f.kelompok, g.nilaimin, i.tahunajaran
            FROM 
                nap a 
                inner join pelajaran b on a.idpelajaran=b.replid 
                inner join komenrapor c on a.idinfo=c.replid 
                inner join siswa d on a.nis=d.nis 
                inner join aturannhb e on a.idaturan=e.replid 
                inner join kelompokpelajaran f on b.idkelompok=f.replid
            
                inner join infonap g on a.idinfo=g.replid
                inner join kelas h on g.idkelas=h.replid
                inner join tahunajaran i on h.idtahunajaran=i.replid
            
            where 
                d.nis='$nis'and 
                g.idsemester='$sem' and 
                f.kode='$jenis' and 
                e.dasarpenilaian like '%$tipe%' and 
                i.tahunajaran='$tahun' and 
                a.idpelajaran='$mapel'
        ");
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data2,
        ]);
    }

    public function nilaiHarian(Request $request)
    {
        // $mapel = $request->input('mapel');
        $jenis = $request->input('jenis'); //2942
        // $sem = $request->input('sem');
        // $tahun = $request->input('tahun'); //2022/2023
        $nis = Auth::user()->nis;
        $data = DB::select("
            select 
                b.tanggal,a.nilaiujian,a.keterangan,a.ts,c.keterangan as keterangan2,c.jenisujian,d.nama,b.kode,f.tahunajaran
            from 
                nilaiujian a 
                inner join ujian b on a.idujian=b.replid
                inner join jenisujian c on b.idjenis=c.replid
                inner join pelajaran d on b.idpelajaran=d.replid
            
                inner join kelas e on b.idkelas=e.replid
                inner join tahunajaran f on f.replid=e.idtahunajaran
            
            where 
                a.nis='$nis' 
                and c.replid='$jenis'
            ORDER BY 
                c.jenisujian ASC;
            
        ");
        //kondisi lebih detail tambahkan where di bawah
        // and b.idpelajaran='$mapel'
        // and f.tahunajaran='$tahun' 
        // and b.idsemester='$sem'
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function nilaiHarianJenis(Request $request)
    {
        $mapel = $request->input('mapel'); //121
        // $kelas = $request->input('kelas');
        $sem = $request->input('sem');
        $tahun = $request->input('tahun'); //2022/2023
        $nis = Auth::user()->nis; //21220025
        $data = DB::select("
            select 
                c.replid,c.jenisujian
            from 
                nilaiujian a 
            inner join ujian b on a.idujian=b.replid
            inner join jenisujian c on b.idjenis=c.replid
            inner join pelajaran d on b.idpelajaran=d.replid
        
            inner join kelas e on b.idkelas=e.replid
            inner join tahunajaran f on f.replid=e.idtahunajaran
        
            where 
                a.nis='$nis' 
                and b.idpelajaran='$mapel' 
                and f.tahunajaran='$tahun' 
                and b.idsemester='$sem'
            GROUP by 
                c.replid, 
                c.jenisujian
            ORDER BY c.jenisujian ASC;
            
        ");
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function mapelNilai(Request $request)
    {
        $nis = Auth::user()->nis; //21220025
        $jenis = $request->input('jenis'); //KMK
        $sem = $request->input('sem');// 21
        $tahun = $request->input('tahun'); //2022/2023
        $data = DB::select("
            select 
                b.idpelajaran,d.kode,d.nama
            from 
                nilaiujian a 
            inner join ujian b on a.idujian=b.replid
            inner join pelajaran d on b.idpelajaran=d.replid
            inner join kelompokpelajaran c on d.idkelompok=c.replid
        
            inner join kelas e on b.idkelas=e.replid
            inner join tahunajaran f on f.replid=e.idtahunajaran
        
            where 
                a.nis='$nis' 
                and f.tahunajaran='$tahun' 
                and b.idsemester='$sem'
                and c.kode='$jenis'
            GROUP BY
                b.idpelajaran,d.kode,d.nama
            ORDER BY
                d.nama
        ");
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function maple(Request $request)
    {
        $jenis = $request->input('jenis');
        $data = DB::select("
            select 
                a.replid,a.nama 
            from 
                pelajaran a 
                inner join kelompokpelajaran b on a.idkelompok=b.replid
            where 
                b.kode='$jenis'
        ");
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function semester()
    {
        $data = SemesterModel::all();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);   
    }

    public function tahun()
    {
        $nis = Auth::user()->nis;
        // $data = TahunModel::orderBy("tahunajaran", "asc")->get();
        $data = DB::select("
            select 
                d.replid,d.tahunajaran,d.departemen
            from 
                nap a
                inner join infonap b on a.idinfo=b.replid
                inner join kelas c on b.idkelas=c.replid
                inner join tahunajaran d on c.idtahunajaran=d.replid  
            where 
                a.nis='$nis'
            GROUP by 
                d.tahunajaran,d.replid,d.departemen
            ");
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
                            ->WhereMonth('ts','=',$month)
                            ->whereYear('ts','=',$year);
        $data2 = PhsiswaModel::where('nis','=',Auth::user()->nis)
                            ->WhereMonth('ts','=',$month)
                            ->whereYear('ts','=',$year);

        $dataHadir = $data->where('hadir','=','1')
                            ->count();
        $dataIjin = $data->where('ijin','=','1')
                            ->count();
        $dataSakit = $data->where('sakit','=','1')
                            ->count();
        $dataAlpa = $data->where('alpa','=','1')
                            ->count();
                            
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data2->get(),
            'dataHitung' => [
                'hadir' => $dataHadir,
                'ijin' => $dataIjin,
                'sakit' => $dataSakit,
                'alpa' => $dataAlpa,
            ],
        ]);
    }

    public function pHarianSiswaHitung(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $dataHadir='';
        $data = PhsiswaModel::where('nis','=',Auth::user()->nis)
                            ->whereYear('ts','=',$year)
                            ->WhereMonth('ts','=',$month);
        $dataHadir = $data->where('hadir','=','1')
                            ->count();
        $dataIjin = $data->where('ijin','=','1')
                            ->count();
        $dataSakit = $data->where('sakit','=','1')
                            ->count();
        $dataAlpa = $data->where('alpa','=','1')
                            ->count();
        
                            
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => [
                'hadir' => $dataHadir,
                'ijin' => $dataIjin,
                'sakit' => $dataSakit,
                'alpa' => $dataAlpa,
            ],
        ]);
    }

    public function absenPelajaran(Request $request)
    {
        $nis=Auth::user()->nis;
        $year=$request->input('year');
        // b.idpelajaran,
        // c.nama,
        $results = DB::select("
        SELECT 
            YEAR(a.ts) AS tahun, 
            MONTH(a.ts) AS bulan, 
            COUNT(CASE WHEN a.statushadir = 0 THEN 1 ELSE NULL END) AS hadir,
            COUNT(CASE WHEN a.statushadir = 1 THEN 1 ELSE NULL END) AS sakit,
            COUNT(CASE WHEN a.statushadir = 2 THEN 1 ELSE NULL END) AS ijin,
            COUNT(CASE WHEN a.statushadir = 3 THEN 1 ELSE NULL END) AS alpa,
            COUNT(CASE WHEN a.statushadir = 4 THEN 1 ELSE NULL END) AS cuti,

            CASE (MONTH(a.ts)) 
                    WHEN '1' THEN 'Januari'
                    WHEN '2' THEN 'Februari'
                    WHEN '3' THEN 'Maret'
                    WHEN '4' THEN 'April'
                    WHEN '5' THEN 'Mei'
                    WHEN '6' THEN 'Juni'
                    WHEN '7' THEN 'Juli'
                    WHEN '8' THEN 'Agustus'
                    WHEN '9' THEN 'September'
                    WHEN '10' THEN 'Oktober'
                    WHEN '11' THEN 'November'
                    WHEN '12' THEN 'Desember'
                    ELSE (MONTH(a.ts))
                END AS namaBulan
            
        FROM 
            ppsiswa a
            inner join presensipelajaran b on a.idpp=b.replid
            inner join pelajaran c on b.idpelajaran=c.replid
        where 
            a.nis='$nis' and year(a.ts)='$year'
        GROUP BY 
            YEAR(a.ts), 
            MONTH(a.ts), 
            namaBulan
            ");
            // c.nama,
            // b.idpelajaran;

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $results,
        ]);
    }

    public function absenPelajaranDetail(Request $request)
    {
        $nis=Auth::user()->nis; //21220025
        $year=$request->input('year'); //2023
        $month=$request->input('month'); //1
        $status=$request->input('status'); //0
        /*
            ? keterangan status
            ? 0 hadir
            ? 1 sakit
            ? 2 ijin
            ? 3 alpa
        */

        $results = DB::select("
        SELECT 
           b.tanggal,b.jam ,c.nama
        FROM 
            ppsiswa a
            inner join presensipelajaran b on a.idpp=b.replid
            inner join pelajaran c on b.idpelajaran=c.replid
        where 
            a.nis='$nis' 
            and month(a.ts)='$month' 
            and year(a.ts)='$year' 
            and a.statushadir='$status'
        ");
            // c.nama,
            // b.idpelajaran;

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $results,
        ]);
    }

    public function absenPerPelajaranMapel(Request $request)
    {
        $nis=Auth::user()->nis; //21220025
        $year=$request->input('year'); //2023
        $month=$request->input('month'); //1

        $results = DB::select("
        SELECT 
           b.idpelajaran,
           c.nama
        FROM 
            ppsiswa a
            inner join presensipelajaran b on a.idpp=b.replid
            inner join pelajaran c on b.idpelajaran=c.replid
        where 
            a.nis='$nis' 
            and month(a.ts)='$month' 
            and year(a.ts)='$year'
        GROUP BY 
            b.idpelajaran,c.nama
        ");
            // c.nama,
            // b.idpelajaran;

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $results,
        ]);
    }

    public function absenPerPelajaranMapelDetail(Request $request)
    {
        $nis=Auth::user()->nis; //21220025
        $year=$request->input('year'); //2023
        $month=$request->input('month'); //1
        $mapel=$request->input('mapel'); //49

        $results = DB::select("
        SELECT 
            YEAR(a.ts) AS tahun, 
            MONTH(a.ts) AS bulan, 
            COUNT(CASE WHEN a.statushadir = 0 THEN 1 ELSE NULL END) AS hadir,
            COUNT(CASE WHEN a.statushadir = 1 THEN 1 ELSE NULL END) AS sakit,
            COUNT(CASE WHEN a.statushadir = 2 THEN 1 ELSE NULL END) AS ijin,
            COUNT(CASE WHEN a.statushadir = 3 THEN 1 ELSE NULL END) AS alpa,
            COUNT(CASE WHEN a.statushadir = 4 THEN 1 ELSE NULL END) AS cuti
            
        FROM 
            ppsiswa a
            inner join presensipelajaran b on a.idpp=b.replid
            inner join pelajaran c on b.idpelajaran=c.replid
        where 
            a.nis='$nis' 
            and year(a.ts)='$year' 
            and month(a.ts)='$month' 
            and b.idpelajaran='$mapel'
        GROUP BY 
            YEAR(a.ts), 
            MONTH(a.ts);
        ");
            // c.nama,
            // b.idpelajaran;

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $results,
        ]);
    }

    public function tahunAbsen()
    {
        $currentYear = date('Y');
    
        // Calculate the year 5 years ago
        $fiveYearsAgo = $currentYear - 4;

        // Generate an array containing the years between $fiveYearsAgo and $currentYear
        $years = range($fiveYearsAgo, $currentYear);

        // Create an empty array to store the result
        $result = [];
        $i=1;

        // Loop through each year and add it to the result array
        foreach ($years as $year) {
            // Generate some dummy data for the year
            $data = [
                'replid' => $i++,
                'tahunajaran' => $year,
                'departemen' => ''
            ];

            // Add the data to the result array
            $result[] = $data;
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $result,
        ]);
    }
}
