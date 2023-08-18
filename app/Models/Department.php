<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $hidden =[
        'created_at',
        'updated_at',
        ];
    protected $table = 'departments';
    protected $fillable =[
        'title',
        'manager_id',
    ];

    public function users(){
        return $this->hasMany(User::class); //one to many relationship with the user model
    }

    public function manager()
    {
        return $this->hasOne(User::class);
    }

}
