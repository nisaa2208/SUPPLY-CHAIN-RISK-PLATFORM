<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;


    protected $fillable=[

        'country_id',
        'supplier_id',
        'name',
        'category',
        'stock',
        'shipping_status',
        'risk_score'

    ];



    //=====================
    // RELATIONSHIP
    //=====================


    public function country()
    {

        return $this->belongsTo(

            Country::class

        );

    }



    public function supplier()
    {

        return $this->belongsTo(

            Supplier::class

        );

    }


}