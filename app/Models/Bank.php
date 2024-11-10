<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'owner_name',
        'bank_name',
        'number'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
