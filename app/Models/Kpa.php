<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kpa extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'kpas';
    protected $primaryKey = 'id';
    protected $hidden =[
        'created_at',
        'updated_at',
        'strategic_domain_id',
        ];

    protected $fillable =[
        'title',
        'strategic_domain_id'
    ];

    public function strategicDomain(){
        return $this->belongsTo(StrategicDomain::class, 'strategic_domain_id'); //one to many relationship with strategic_domains model.
    }
    public function keyPerformanceIndicator(){
        return $this->hasMany(Kpi::class, 'kpas_id');
    }
}
