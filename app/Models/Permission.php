<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;

    protected $hidden =[
        'created_at',
        'updated_at',
        ];

    protected $table = 'permissions';

    protected $fillable =[
        'title',
        'description'
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, Permit::class);
    }

    protected  static  function  boot()
    {
        parent::boot();

        static::creating(function  ($model)  {
            $model->uuid = (string) Str::uuid();
        });
    }
}
