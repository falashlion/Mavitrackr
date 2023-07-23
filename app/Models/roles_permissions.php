<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class roles_permissions extends Pivot
{
    use HasFactory;
    protected $table = 'roles_permissions';
}
