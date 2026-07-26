<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;

class GlobalAlertController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | High Risk Countries
        |--------------------------------------------------------------------------
        */

        $countries = Country::where('risk_level', 'High')
            ->orderByDesc('risk_score')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | High Risk Suppliers
        |--------------------------------------------------------------------------
        */

        $suppliers = Supplier::where('risk_score', '>=', 80)
            ->orderByDesc('risk_score')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | High Risk Products
        |--------------------------------------------------------------------------
        */

        $products = Product::where('risk_score', '>=', 80)
            ->orderByDesc('risk_score')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalCountryAlert = $countries->count();
        $totalSupplierAlert = $suppliers->count();
        $totalProductAlert  = $products->count();

        $totalAlert = $totalCountryAlert
                    + $totalSupplierAlert
                    + $totalProductAlert;

        /*
        |--------------------------------------------------------------------------
        | Latest Critical Alert
        |--------------------------------------------------------------------------
        */

        $latestCountry = $countries->first();
        $latestSupplier = $suppliers->first();
        $latestProduct = $products->first();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('global-alert.index', compact(
            'countries',
            'suppliers',
            'products',
            'totalCountryAlert',
            'totalSupplierAlert',
            'totalProductAlert',
            'totalAlert',
            'latestCountry',
            'latestSupplier',
            'latestProduct'
        ));
    }
}