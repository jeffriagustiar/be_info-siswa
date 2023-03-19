<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'tahunajaran';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'tahunajaran',
        'departemen',
        
    ];
    protected $hidden = [
        'tglmulai',
        'tglakhir',
        'aktif',
        'keterangan',
        'info1',
        'info2',
        'info3',
        'ts',

        'token',
        'issync',
    ];
}
