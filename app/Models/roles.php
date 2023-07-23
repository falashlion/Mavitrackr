<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    use HasFactory;
    public function permissions()
    {
        return $this->belongsToMany(permissions::class);
    }
    public function users()
    {
        return $this->belongsToMany(users::class);
    }
}
