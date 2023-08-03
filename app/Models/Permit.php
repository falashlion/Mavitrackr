<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    protected $hidden =[
        'created_at',
        'updated_at',
        ];

    protected $table = 'permits';
}
