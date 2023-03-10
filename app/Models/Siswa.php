<?php

namespace App\Models;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'nis',
        'nisn',
        'nik',
        'nama',
        'panggilan',
        'idkelas',
        'suku',
        'agama',
        'kondisi',
        'kelamin',
        'tmplahir',
        'tgllahir',
        'anakke',
        'jsaudara',
        'berat',
        'tinggi',
        'darah',
        'alamatsiswa',
        'telponsiswa',
        'emailsiswa',
        'hpsiswa',
        'asalsekolah',
        'noijasah',
        'tglijasah',
        'namaayah',
        'namaibu',
        'statusayah',
        'statusibu',
        'tmplahirayah',
        'tmplahiribu',
        'tgllahirayah',
        'tgllahiribu',
        'pendidikanayah',
        'pendidikanibu',
        'pekerjaanayah',
        'pekerjaanibu',
        'wali',
        'penghasilanayah',
        'penghasilanibu',
        'alamatortu',
        'hportu',
        'emailayah',
        'alamatsurat',
        'hobi',
        'api_token',
        'pinsiswa',
        'pinortu',
        'pinortuibu',
    ];

    protected $hidden = [
        'foto',
        'noun',
        'aktif',
        'tahunmasuk',
        'idangkatan',
        'status',
        'warga',
        'statusanak',
        'jkandung',
        'jtiri',
        'bahasa',
        'jarak',
        'kodepossiswa',
        'kesehatan',
        'ketsekolah',
        'almayah',
        'almibu',
        'telponortu',
        'keterangan',
        'frompsb',
        'ketpsb',
        'statusmutasi',
        'alumni',
        'emailibu',
        'info1',
        'info2',
        'info3',
        'ts',
        'token',
        'issync',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'idkelas','replid');
    }
}
