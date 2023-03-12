<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelajaranModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'pelajaran';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'kode',
        'nama',
        'departemen',
        'idkelompok',
        'sifat',
        'aktif',
        'keterangan',
        'info1',
        'info2',
        'info3',
    ];
    protected $hidden = [
        'ts',
        'token',
        'issync',
    ];
}
