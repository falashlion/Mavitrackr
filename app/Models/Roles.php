<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{

    use HasFactory;
    protected $table = 'roles';
    public function Permission()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function User()
    {
        return $this->belongsToMany(User::class);
    }
}