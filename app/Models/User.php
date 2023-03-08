<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
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
        'hpsiswa',
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
}
