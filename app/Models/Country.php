<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    /**
     * Mass Assignment
     */
    protected $fillable = [
        'name',
        'code',
        'region',
        'risk_score',
        'risk_level',
        'trade_index',
        'shipping_status',
        'supply_status',
        'latitude',
        'longitude',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'risk_score' => 'integer',
        'trade_index' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeHighRisk($query)
    {
        return $query->where('risk_score', '>=', 80);
    }

    public function scopeMediumRisk($query)
    {
        return $query->whereBetween('risk_score', [50, 79]);
    }

    public function scopeLowRisk($query)
    {
        return $query->where('risk_score', '<', 50);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusAttribute()
    {
        return $this->risk_level;
    }

    public function getRiskColorAttribute()
    {
        if ($this->risk_score >= 80) {
            return 'danger';
        }

        if ($this->risk_score >= 50) {
            return 'warning';
        }

        return 'success';
    }

    public function getRiskBadgeAttribute()
    {
        if ($this->risk_score >= 80) {
            return '<span class="badge badge-danger">High</span>';
        }

        if ($this->risk_score >= 50) {
            return '<span class="badge badge-warning">Medium</span>';
        }

        return '<span class="badge badge-success">Low</span>';
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isHighRisk()
    {
        return $this->risk_score >= 80;
    }

    public function isMediumRisk()
    {
        return $this->risk_score >= 50 && $this->risk_score < 80;
    }

    public function isLowRisk()
    {
        return $this->risk_score < 50;
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Helpers
    |--------------------------------------------------------------------------
    */

    public function getMarkerColorAttribute()
    {
        if ($this->risk_score >= 80) {
            return 'red';
        }

        if ($this->risk_score >= 50) {
            return 'orange';
        }

        return 'green';
    }

    public function getCoordinatesAttribute()
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
        ];
    }
}