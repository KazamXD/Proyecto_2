<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }
}