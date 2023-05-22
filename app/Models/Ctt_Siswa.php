<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctt_Siswa extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'ctt_siswa';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'id_ctt',
        'nis',
        'tanggal',
        'acc',
        'ket',
        'point',
        'gambar'
    ];
}
