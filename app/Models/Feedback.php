<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory, HasUuids;

    protected $hidden =[
        'created_at',
        'updated_at',
    ];
    protected $table = 'feedbacks';

    protected $fillable =[
        'comment',
        'kpis_id'
    ];
    protected $primaryKey = 'id';
    /**
     * keyPerformanceIndicator
     *
     * @return object
     */
    public function keyPerformanceIndicator(){
        return $this->belongsTo(Kpi::class,'kpis_id');
    }
}
