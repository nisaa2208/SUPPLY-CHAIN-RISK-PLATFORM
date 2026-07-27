<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'email',
        'phone',
        'address',
        'supply_status',
        'risk_score',
    ];

    protected $casts = [
        'risk_score' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getRiskLevelAttribute()
    {
        if ($this->risk_score >= 80) {
            return 'High';
        }

        if ($this->risk_score >= 50) {
            return 'Medium';
        }

        return 'Low';
    }
}