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
        'risk_score'

    ];


    //=========================
    // RELATIONSHIP
    //=========================

    public function country()
    {

        return $this->belongsTo(
            Country::class
        );

    }



    public function products()
    {

        return $this->hasMany(
            Product::class
        );

    }


}