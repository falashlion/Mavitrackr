<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kpas extends Model
{
    use HasFactory;
    public function strategic_domains(){
        return $this->belongsTo(strategic_domains::class); //one to many relationship with strategic_domains model.
    }
    public function kpis(){
        return $this->hasMany(kpis::class);
    }
}
