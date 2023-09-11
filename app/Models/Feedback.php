<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Feedback extends Model
{
    use HasFactory, HasUuids;

    protected $hidden =[
        'created_at',
        'updated_at',
        // 'kpis_id',
        ];
    protected $table = 'feedbacks';

    protected $fillable =[
        'comment',
        'kpis_id'
    ];
    public function keyPerformanceIndicator(){
        return $this->belongsTo(Kpi::class,'kpis_id');
    }
}
