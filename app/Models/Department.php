<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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

    /**
     * users
     *
     * @return object
     */
    public function users(){
        return $this->hasMany(User::class, 'departments_id'); //one to many relationship with the user model
    }

    /**
     * manager
     *
     * @return object
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

}
