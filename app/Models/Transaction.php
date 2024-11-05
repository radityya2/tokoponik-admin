<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'bank_id',
        'grand_total',
        'status',
        'proof'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Bank
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
