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

    protected $hidden =[
        'created_at',
        'updated_at',
        'strategic_domains_id',
        ];

    protected $fillable =[

        'title',
        'strategic_domains_id'
    ];

    public function strategicDomain(){
        return $this->belongsTo(StrategicDomain::class, 'strategic_domains_id'); //one to many relationship with strategic_domains model.
    }
    public function kpi(){
        return $this->hasMany(Kpi::class, 'kpas_id');
    }

    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }
}
