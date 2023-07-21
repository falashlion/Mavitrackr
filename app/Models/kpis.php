<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kpis extends Model
{
    use HasFactory;
    public function kpas()
    {
        return $this->hasMany(kpas::class);
    }
}
