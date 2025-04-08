<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class AdminModel extends Model
{
    use HasApiTokens;

    protected $hidden = [
        'password',
        'token'
    ];

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'token'
    ];
}
