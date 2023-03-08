<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'besarjtt';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'nis',
        'idpenerimaan',
        'besar',
        'cicilan',
        'lunas',
        'keterangan',
        'pengguna',
        'info1',
        'info2',
        'info3',
        'ts',
        'token',
        'issync',

    ];
}
