<?php

namespace App\Models\Guru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql4';
    protected $table = 'pegawai';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'nip',
        'nrp',
        'nuptk',
        'nama',
        'panggilan',
        'gelarawal',
        'gelarakhir',
        'gelar',
        'tmplahir',
        'tgllahir',
        'agama',
        'suku',
        'noid',
        'alamat',
        'telpon',
        'handphone',
        'email',
        'bagian',
        'nikah',
        'keterangan',
        'aktif',
        'kelamin',
        'pinpegawai',
        'mulaikerja',
        'status',
        'ketnonaktif',
        'pensiun',
    ];

    protected $hidden = [
        'foto',
        'doaudit',
        'info1',
        'info2',
        'info3',
        'ts',
        'token',
        'issync',
        
        'facebook',
        'twitter',
        'website',
    ];
}
