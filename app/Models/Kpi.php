<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Kpi extends Model
{
    use HasFactory, HasUuids;

    protected $hidden =
    [
        'created_at',
        'updated_at',
        'kpas_id',
        'indicators',
    ];

    protected $fillable =
    [
        'kpas_id',
        'user_id',
        'title',
        'weighted_average_score',
        'score',
        'weight',
        'status',
    ];

    protected $table = 'kpis';
    protected $primaryKey = 'id';
    public function keyPerformanceArea()
    {
        return $this->belongsTo(Kpa::class, 'kpas_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select(['id', 'first_name', 'profile_image','last_name']);
    }
    public function feedback()
    {
        return $this->hasMany(Feedback::class,'kpis_id');
    }
    // public function reviews(){
    //     return $this->hasOne(Review::class, 'user_id');
    // }
}
