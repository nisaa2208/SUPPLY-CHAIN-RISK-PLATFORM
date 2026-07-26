<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;

class MonitoringController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        $suppliers = Supplier::with('country')->get();
        $products = Product::all();

        return view('monitoring.index', compact(
            'countries',
            'suppliers',
            'products'
        ));
    }
}