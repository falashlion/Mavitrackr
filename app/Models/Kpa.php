<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpa extends Model
{
    use HasFactory;
    protected $table = 'kpas';

    protected $hidden =[
        'created_at',
        'updated_at',
        'strategic_domains_id',
        ];

    protected $fillable =[

        'title',
        'strategic_domains_id'
    ];

    public function StrategicDomain(){
        return $this->belongsTo(StrategicDomain::class); //one to many relationship with strategic_domains model.
    }
    public function Kpi(){
        return $this->hasMany(Kpi::class);
    }
}
