<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $hidden =[
        'created_at',
        'updated_at',
        'kpis_id',
        ];
    protected $table = 'feedbacks';

    protected $fillable =[
        'comment',
        'kpis_id'
    ];
    public function kpi(){
        return $this->hasMany(Kpi::class);
    }
}
