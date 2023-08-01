<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategicDomain extends Model
{
    use HasFactory;
    protected $table = 'strategic_domains';
    protected $fillable =[
        'title',
    ];
    public function Kpa()
    {
        return $this->hasMany(Kpa::class);
    }
}
