<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory, Notifiable;
    protected $table = 'roles';

    protected $hidden =[
        // 'pivot',
        'updated_at',
        'created_at',
    ];
}
