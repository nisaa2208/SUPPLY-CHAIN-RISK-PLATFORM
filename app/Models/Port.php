<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'city',
        'latitude',
        'longitude',
        'port_code',
        'status',
        'port_type',
        'congestion_level',
        'risk_level',
        'risk_score',
        'description',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'risk_score' => 'integer',
    ];
}