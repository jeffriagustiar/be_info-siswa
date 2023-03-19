<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterModel extends Model
{
    use HasFactory;protected 
    $connection = 'mysql';
    protected $table = 'semester';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'semester',
        'departemen',
        
    ];
    protected $hidden = [
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
