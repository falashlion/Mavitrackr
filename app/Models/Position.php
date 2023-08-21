<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $hidden =[
        'created_at',
        'updated_at',
        'uuid',
        'id'
        ];

    protected $table = 'positions';

    protected $fillable =[
        'title',
    ];
    public function users(){
        return $this->hasMany(User::class, 'positions_id');
    }
}
