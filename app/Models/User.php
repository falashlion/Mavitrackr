<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, HasUuids;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable =[
        'password',
        'user_matricule',
        'profile_image',
        'first_name',
        'last_name',
        'phone',
        'address',
        'line_manager',
        'gender',
        'email',
        'departments_id',
        'positions_id',
        'id'
    ];

    protected $hidden =[
        'password',
        'departments_id',
        'positions_id',
        'created_at',
        'updated_at',
        'remember_token',
        'email_verified_at',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function keyPerformanceIndicators(){
        return $this->hasMany(Kpi::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }

    // public function roles()
    // {
    //     return $this->belongsToMany( Role::class, 'accesses', 'role_id','user_id');
    // }
    /**
     * Summary of positions
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'positions_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'line_manager');
    }
    public function lineManager()
    {
        return $this->belongsTo(User::class, 'line_manager');
    }

 /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims() {
        return [
            //
        ];
    }
}
