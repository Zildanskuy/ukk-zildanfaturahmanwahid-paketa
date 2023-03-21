<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = 'id_petugas';
    protected $fillable = [
        'nik',
        'name',
        'email',
        'phone',
        'password',
        'roles',
    ];
}
