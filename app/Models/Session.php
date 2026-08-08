<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    /**
     * PENTING: Menentukan nama tabel yang benar secara manual.
     * Ini akan memberitahu Laravel untuk mencari tabel 'consult_sessions'
     * bukan 'sessions'. Inilah baris yang memperbaiki error.
     *
     * @var string
     */
    protected $table = 'consult_sessions';

    protected $fillable = [
        'user_id',
        'konselor_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'konselor_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}