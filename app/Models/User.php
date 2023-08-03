<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable ;

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
        'is_manager',
        'gender',
        'email',
        'departments_id',
        'positions_id',
    ];

    // protected $hidden =[
    //     'password',
    //     'departments_id',
    //     'positions_id',
    //     'created_at',
    //     'updated_at',
    //     'remember_token',
    //     'email_verified_at',
    // ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    protected $casts = [
        'is_manager' => 'boolean',
    ];

    public function Kpi(){
        return $this->hasMany(Kpi::class, 'kpis_id');
    }

    public function Department(){
        return $this->belongsTo(Department::class, 'departments_id');
    }

    public function Role()
    {
        return $this->belongsToMany(Role::class);
    }
    /**
     * Summary of positions
     */
    public function Position()
    {
        return $this->belongsTo(Position::class, 'positions_id');
    }


        public function managers(){
            return $this->hasMany(User::class)->where('is_manager', true);
        }
 /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->user_matricule;
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
