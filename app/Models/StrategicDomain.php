<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class StrategicDomain extends Model
{
    use HasFactory,  HasUuids;
    protected $hidden =[
    'created_at',
    'updated_at',
    ];

    use HasFactory;
    protected $table = 'strategic_domains';
    protected $fillable =[
        'title',
    ];
    public function kpa()
    {
        return $this->hasMany(Kpa::class);
    }

    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }
}
