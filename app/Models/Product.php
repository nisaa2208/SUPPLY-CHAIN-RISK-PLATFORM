<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * Mass Assignment
     */
    protected $fillable = [
        'country_id',
        'supplier_id',
        'name',
        'category',
        'stock',
        'shipping_status',
        'risk_score',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'stock' => 'integer',
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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

    public function isCritical()
    {
        return $this->shipping_status === 'Critical';
    }

    public function isDelayed()
    {
        return $this->shipping_status === 'Delayed';
    }

    public function isNormal()
    {
        return $this->shipping_status === 'Normal';
    }

    public function isLowStock()
    {
        return $this->stock <= 10;
    }
}