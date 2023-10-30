<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kpa extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'kpas';
    protected $hidden =[
        'created_at',
        'updated_at',
        'strategic_domain_id',
    ];
    protected $fillable =[
        'title',
        'strategic_domain_id'
    ];

    /**
     * strategicDomain
     *
     * @return object startegic domain
     * defines the one to many relationship with strategic_domains model.
     */
    public function strategicDomain(){
        return $this->belongsTo(StrategicDomain::class);
    }
    /**
     * keyPerformanceIndicator
     *
     * @return object Kpi
     * defines the many to one relationship between the key performance area and the key performance indicator.
     */
    public function keyPerformanceIndicator(){
        return $this->hasMany(Kpi::class, 'kpas_id');
    }
}
