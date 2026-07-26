<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\Product;

class Country extends Model
{
    use HasFactory;


    //==================================
    // MASS ASSIGNMENT
    //==================================

    protected $fillable = [

        'name',
        'code',
        'capital',
        'region',
        'currency',
        'population',
        'risk_level',
        'risk_score',
        'trade_index',
        'supply_status',
        'shipping_status',

    ];


    //==================================
    // RELATIONSHIP
    //==================================

    public function suppliers()
    {
        return $this->hasMany(
            Supplier::class
        );
    }


    public function products()
    {
        return $this->hasMany(
            Product::class
        );
    }


    //==================================
    // GET RISK STATUS
    //==================================

    public function getRiskStatus()
    {

        if ($this->risk_score >= 71) {

            return "High";

        }


        if ($this->risk_score >= 31) {

            return "Medium";

        }


        return "Low";

    }



    //==================================
    // SUPPLY STATUS
    //==================================

    public function isSupplyDelayed()
    {

        return $this->supply_status == "Delayed";

    }



    //==================================
    // SHIPPING STATUS
    //==================================

    public function isShippingDelayed()
    {

        return $this->shipping_status == "Delayed";

    }


}