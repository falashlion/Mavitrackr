<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    use HasFactory;

    protected $table = 'kpis';
    public function Kpa()
    {
        return $this->belongsTo(Kpa::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Feedback(){
        return $this->belongsTo(Feedback::class);
    }
}
