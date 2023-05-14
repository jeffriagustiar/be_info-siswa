<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctt_Kategori extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'ctt_kategori';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;

    protected $fillable = [
        'replid',
        'nama_kategori',
        'kategori',
        'ket',
        'ts'

    ];
    
    public function detail()
    {
        return $this->hasMany(Ctt_Bb::class,'id_kategori','replid');
    }
}
