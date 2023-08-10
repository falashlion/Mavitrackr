<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    use HasFactory;

    protected $hidden =[
        'created_at',
        'updated_at',
        'kpas_id',
        ];

        protected $fillable =[
            'kpas_id',
            'users_id',
            'title',
            'weighted_average_score',
            'score',
            'weight',
            'indicators',
            'status',
        ];

    protected $table = 'kpis';
    public function kpa()
    {
        return $this->belongsTo(Kpa::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function feedback(){
        return $this->belongsTo(Feedback::class);
    }
}
