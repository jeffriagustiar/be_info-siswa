<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'kelas';
     
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'kelas',
        'idtahunajaran',
        'kapasitas',
        'nipwali',
        'aktif',
        'keterangan',
        'idtingkat',
    ];

    protected $hidden = [
        'info1',
        'info2',
        'info3',
        'ts',
        'token',
        'issync',
    ];
}
