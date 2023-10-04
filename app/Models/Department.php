<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Department extends Model
{
    use HasFactory, HasUuids;

    protected $hidden =
    [
        'created_at',
        'updated_at',
    ];
    protected $primaryKey = 'id';
    protected $table = 'departments';
    protected $fillable =
    [
        'title',
        'manager_id',
        'id'
    ];

    public function users(){
        return $this->hasMany(User::class, 'departments_id'); //one to many relationship with the user model
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

}
