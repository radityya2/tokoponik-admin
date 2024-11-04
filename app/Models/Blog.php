<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal
     */
    protected $fillable = [
        'title',
        'description',
        'blog_picture',
        'blog_link'
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
