<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'package_name',
        'token_amount',
        'price',
        'status',
        'snap_token',
    ];

    protected $casts = [
        'type' => 'string',
        'amount' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}