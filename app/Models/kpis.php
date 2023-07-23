<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kpis extends Model
{
    use HasFactory;
    public function kpas()
    {
        return $this->belongsTo(kpas::class);
    }

    public function users(){
        return $this->belongsTo(users::class);
    }
    public function feedback(){
        return $this->belongsTo(feedback::class);
    }
}
