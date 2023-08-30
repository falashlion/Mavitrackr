<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory, HasRoles;// HasUuids ;

    use HasFactory;
    protected $hidden =[
        'created_at',
        'updated_at',
        'pivot',
        'id',
        'uuid',
        'description',

        ];

    protected $fillable =[
        "title",
        "description"
    ];

    protected $table = 'roles';
    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function user()
    {
        return $this->belongsToMany( User::class, 'accesses');
    }

}
