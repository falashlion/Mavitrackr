<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class strategic_domains extends Model
{
    use HasFactory;
    public function kpas()
    {
        return $this->belongsTo(kpas::class);
    }
}
