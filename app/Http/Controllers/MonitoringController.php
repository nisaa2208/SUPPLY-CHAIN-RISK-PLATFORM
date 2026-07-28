<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;

class MonitoringController extends Controller
{
    public function index()
    {
        $highRisk = Country::where('risk_score', '>=', 80)->count();

        $mediumRisk = Country::whereBetween('risk_score', [50, 79])->count();

        $lowRisk = Country::where('risk_score', '<', 50)->count();

        $normalShipping = Product::where('shipping_status', 'Normal')->count();

        $delayedShipping = Product::where('shipping_status', 'Delayed')->count();

        $criticalShipping = Product::where('shipping_status', 'Critical')->count();

        $countries = Country::latest()->take(10)->get();

        $suppliers = Supplier::with('country')
            ->latest()
            ->take(5)
            ->get();

        return view('monitoring.index', compact(
            'highRisk',
            'mediumRisk',
            'lowRisk',
            'normalShipping',
            'delayedShipping',
            'criticalShipping',
            'countries',
            'suppliers'
        ));
    }
}