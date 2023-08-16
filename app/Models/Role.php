<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasFactory, HasRoles ;

    use HasFactory;
    protected $hidden =[
        'created_at',
        'updated_at',
        ];

    protected $fillable =[
        "title",
        "description"
    ];

    protected $table = 'roles';
    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'permissions');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'accesses', Access::class);
    }
}
