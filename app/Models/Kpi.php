<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Kpi extends Model
{
    use HasFactory;// HasUuids;

    protected $hidden =[
        'created_at',
        'updated_at',
        'kpas_id',
        'indicators',
        ];

        protected $fillable =[
            'kpas_id',
            'users_id',
            'title',
            'weighted_average_score',
            'score',
            'weight',
            'status',
        ];

    protected $table = 'kpis';
    public function kpa()
    {
        return $this->belongsTo(Kpa::class, 'kpas_id');
    }

    public function user(){
        return $this->belongsTo(User::class);//, 'users_id'
    }
    public function feedback(){
        return $this->belongsTo(Feedback::class);
    }
    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }
}
