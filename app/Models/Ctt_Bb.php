<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctt_Bb extends Model
{
    use HasFactory;protected $connection = 'mysql';
    protected $table = 'ctt_baik_buruk';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'id_kategori',
        'nama_ctt',
        'point',
        'ket',
        'ts'
    ];
}
