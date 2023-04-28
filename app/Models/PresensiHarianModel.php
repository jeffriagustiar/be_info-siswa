<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiHarianModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'presensiharian';
    protected $primaryKey = 'replid';
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'idkelas',
        'idsemester',
        'tanggal1',
        'tanggal2',
        'hariaktif',
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
