<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NapModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'nap';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'nis',
        'idaturan',
        'idpelajaran',
        'idinfo',
        'nilaiangka',
        'nilaihuruf',
        'komentar',
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
