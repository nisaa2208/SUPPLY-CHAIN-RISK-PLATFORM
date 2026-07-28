<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCache extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'source',
        'description',
        'url',
        'country',
        'category',
        'sentiment',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}