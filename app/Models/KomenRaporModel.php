<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomenRaporModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'komenrapor';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'nis',
        'idkelas',
        'idsemester',
        'jenis',
        'komentar',
        'predikat',
        'info1',
        'info2',
        'info3',
    ];
    protected $hidden = [];
}
