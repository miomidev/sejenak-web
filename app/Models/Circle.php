<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'circle_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function moderators()
    {
        return $this->members()->wherePivot('role', 'moderator');
    }
}