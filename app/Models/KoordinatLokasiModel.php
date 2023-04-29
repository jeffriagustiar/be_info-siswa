<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoordinatLokasiModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'koordinatlokasi';
    protected $primaryKey = 'replid';
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'departemen',
        'jenis',
        'jarak',
        'nama',
        'latitude',
        'longitude',
    ];
}
