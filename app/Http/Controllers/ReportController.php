<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $totalCountries = Country::count();
        $totalSuppliers = Supplier::count();
        $totalProducts  = Product::count();
        $totalUsers     = User::count();

        $highRiskCountries = Country::where('risk_score', '>', 70)->count();
        $highRiskSuppliers = Supplier::where('risk_score', '>', 70)->count();
        $highRiskProducts  = Product::where('risk_score', '>', 70)->count();

        return view('reports.index', compact(
            'totalCountries',
            'totalSuppliers',
            'totalProducts',
            'totalUsers',
            'highRiskCountries',
            'highRiskSuppliers',
            'highRiskProducts'
        ));
    }
}