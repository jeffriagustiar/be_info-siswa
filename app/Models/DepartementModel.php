<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartementModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'tahunajaran';
     
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'tahunajaran',
        'departemen',
        'tglmulai',
        'tglakhir',
        'aktif',
        'keterangan',
    ];
    
    protected $hidden = [
        'info1',
        'info2',
        'info3',
        'token',
        'issync',
    ];
}
