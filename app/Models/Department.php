<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $fillable =[
        'title',
    ];

    public function User(){
        return $this->hasMany(User::class); //one to many relationship with the user model
    }

}