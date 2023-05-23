<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Login extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql3';
    protected $table = 'login';
    protected $primaryKey = 'replid';
     
    public $timestamps = false;

    protected $fillable = [
        'clientid',
        'region',
        'location',
        'replid',
        'login',
        'password',
        'keterangan',
        'aktif',
        'info1',
        'info2',
        'info3',
        'api_token',
        'level',
        'kelola',

    ];
}
