<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Supplier;
use App\Models\Product;

class AnalyticsController extends Controller
{
    public function index()
    {
        $countryCount = Country::count();
        $supplierCount = Supplier::count();
        $productCount = Product::count();

        $highRisk = Country::where('risk_level', 'High')->count();
        $mediumRisk = Country::where('risk_level', 'Medium')->count();
        $lowRisk = Country::where('risk_level', 'Low')->count();

        $topCountries = Country::orderBy('risk_score', 'desc')
                                ->take(5)
                                ->get();

        $topSuppliers = Supplier::latest()
                                ->take(5)
                                ->get();

        $products = Product::latest()
                           ->take(10)
                           ->get();

        $allCountries = Country::orderBy('name')->get();
        $selectedCountry = $allCountries->first();

        $lowRiskCount = $lowRisk;
        $mediumRiskCount = $mediumRisk;
        $highRiskCount = $highRisk;
        $topRiskCountries = $topCountries;

        $regionalRisks = Country::select('region', \DB::raw('AVG(risk_score) as avg_score'))
            ->groupBy('region')
            ->pluck('avg_score', 'region');

        return view('analytics', compact(
            'countryCount',
            'supplierCount',
            'productCount',
            'highRisk',
            'mediumRisk',
            'lowRisk',
            'topCountries',
            'topSuppliers',
            'products',
            'allCountries',
            'selectedCountry',
            'lowRiskCount',
            'mediumRiskCount',
            'highRiskCount',
            'topRiskCountries',
            'regionalRisks'
        ));
    }
}