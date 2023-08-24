<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory, HasUuids;

    protected $hidden =[
        'created_at',
        'updated_at',
        'manager_id',
        'uuid',
        ];
    protected $table = 'departments';
    protected $fillable =[
        'title',
        'manager_id',
    ];

    public function users(){
        return $this->hasMany(User::class); //one to many relationship with the user model
    }

    // public function manager()
    // {
    //     return $this->hasOne(User::class, 'manager_id');
    // }
    public function manager()
{
    return $this->belongsTo(User::class, 'manager_id');
}

protected  static  function  boot()
{
    parent::boot();

    static::creating(function  ($model)  {
        $model->uuid = (string) Str::uuid();
    });
}

}
