<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhsiswaModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'phsiswa';
    protected $primaryKey = 'replid';
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'idpresensi',
        'nis',
        'hadir',
        'ijin',
        'sakit',
        'cuti',
        'alpa',
        'keterangan',
        'ts',
        'masuk',
        'pulang'
    ];

    protected $hidden = [
        'info1',
        'info2',
        'info3',
        'token',
        'issync',
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'nis','nis');
    }
}
