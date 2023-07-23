<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    public function kpis(){
        return $this->hasMany(kpis::class);
    }

    public function departments(){
        return $this->belongsTo(departments::class);
    }

    public function roles()
    {
        return $this->belongsToMany(roles::class);
    }
    public function job_titles()
    {
        return $this->belongsToMany(job_titles::class);
    }
}
