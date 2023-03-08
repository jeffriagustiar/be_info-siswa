<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanSpp extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'penerimaanjtt';
     
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'idbesarjtt',
        'idjurnal',
        'tanggal',
        'jumlah',
        'keterangan',
        'petugas',
        'alasan',
        'info1',
        'info2',
        'info3',
        'ts',
        'token',
        'issync',
    ];
}
