<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'form_name',
        'user_id',
        'status',
        'author_dueDate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $dates = [
        'created_at',
        'updated_at',
        'author_dueDate'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
