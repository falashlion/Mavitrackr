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
    // protected $primaryKey = 'id';
    protected $table = 'strategic_domains';
    protected $fillable =[
        'title',
        'id'
    ];
    public function keyPerformanceArea()
    {
        return $this->hasMany(Kpa::class, 'strategic_domain_id');
    }
}
