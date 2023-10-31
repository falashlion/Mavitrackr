<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Position extends Model
{
    use HasFactory, HasUuids;

    protected $hidden =[
        'created_at',
        'updated_at',
        ];

    protected $table = 'positions';
    protected $primaryKey = 'id';

    protected $fillable =[
        'title',
        'id'
    ];
    public function users(){
        return $this->hasMany(User::class, 'positions_id');
    }

}
