<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class strategic_domains extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
    ];
    public function kpas()
    {
        return $this->hasMany(kpas::class);
    }
}
