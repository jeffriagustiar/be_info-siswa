<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturannhbModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'aturannhb';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;
    protected $fillable = [
        'replid',
        'nipguru',
        'idtingkat',
        'idsemester',
        'idpelajaran',
        'dasarpenilaian',
        'idjenisujian',
        'bobot',
        'aktif',
        'keterangan',
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
