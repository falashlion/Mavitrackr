<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Tymon\JWTAuth\Contracts\JWTSubject;

class users extends Authenticatable  implements JWTSubject
{
    use HasFactory;
    public function kpis(){
        return $this->hasMany(kpis::class);
    }

    public function departments(){
        return $this->belongsTo(departments::class);
    }

    public function roles()
    {
        return $this->belongsToMany(roles::class);
    }
    /**
     * Summary of positions
     */
    public function positions()
    {
        return $this->belongsToMany(positions::class);
    }

 /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custdatabase/migrations/2023_07_25_104727_users.phpom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

}
