<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class users extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable ;

    protected $fillable =[
        'Password',
        'user_matricule',
        'profile_image',
        'first_name',
        'last_name',
        'phone',
        'address',
        'is_manager',
        'gender',
        'email',
        'departments_id',
        'positions_id',
    ];

    protected $hidden =[
        'Password',
    ];

    protected $casts = [
        'is_manager' => 'boolean',
    ];


    public function kpis(){
        return $this->hasMany(kpis::class);
    }

    public function departments(){
        return $this->belongsTo(departments::class, 'departments_id');
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
        return $this->belongsToMany(positions::class, 'positions_id');
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
