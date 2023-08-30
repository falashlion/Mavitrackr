<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
// use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;


class User extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles ;

    // private string $user_matricule;

    protected $table = 'users';
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
    ];

    protected $hidden =[
        'password',
        'pivot',
        'departments_id',
        'positions_id',
        'created_at',
        'updated_at',
        'remember_token',
        'email_verified_at',
        'is_manager',
        'uuid',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    protected $casts = [
        'is_manager' => 'boolean',
    ];

    public function kpis(){
        return $this->hasMany(Kpi::class, 'kpis_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'departments_id');
    }

    public function role()
    {
        return $this->belongsToMany( Role::class, 'accesses');
    }
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
        return $this->user_matricule;
    }
    public function getJWTCustomClaims() {
        return [
            'roles' => $this->role()->get(['title']),
        ];
    }
//     protected  static  function  boot()
// {
//     parent::boot();

//     static::creating(function  ($model)  {
//         $model->uuid = (string) Str::uuid();
//     });
// }

}
