<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departments extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(users::class); //one to many relationship with the user model
    }

}
