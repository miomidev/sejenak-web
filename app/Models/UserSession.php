<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'refresh_token',
        'expires_at',
        'last_used_at',
        'device_name',
        'ip_address',
    ];

    protected $dates = [
        'expires_at',
        'last_used_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
