<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    /**
     * Mass Assignment
     */
    protected $fillable = [
        'country_id',
        'name',
        'email',
        'phone',
        'address',
        'supply_status',
        'risk_score',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'risk_score' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function products()
    {
        return $this->hasMany(Product::class);
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

    public function isActive()
    {
        return $this->supply_status === 'Active';
    }
}