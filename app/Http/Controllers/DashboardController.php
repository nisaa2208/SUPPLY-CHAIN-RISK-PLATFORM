<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Total Data
        |--------------------------------------------------------------------------
        */

        $countries = Country::count();
        $suppliers = Supplier::count();
        $products  = Product::count();
        $users     = User::count();

        /*
        |--------------------------------------------------------------------------
        | Risk Statistics
        |--------------------------------------------------------------------------
        */

        $highRisk   = Country::where('risk_level', 'High')->count();
        $mediumRisk = Country::where('risk_level', 'Medium')->count();
        $lowRisk    = Country::where('risk_level', 'Low')->count();

        $averageRisk = round(Country::avg('risk_score'), 1);

        /*
        |--------------------------------------------------------------------------
        | Chart Data
        |--------------------------------------------------------------------------
        */

        $riskChart = [
            $lowRisk,
            $mediumRisk,
            $highRisk,
        ];

        /*
        |--------------------------------------------------------------------------
        | Top Risk Countries
        |--------------------------------------------------------------------------
        */

        $topRiskCountries = Country::orderByDesc('risk_score')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Latest Countries
        |--------------------------------------------------------------------------
        */

        $latestCountries = Country::latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Latest Suppliers
        |--------------------------------------------------------------------------
        */

        $latestSuppliers = Supplier::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Latest Products
        |--------------------------------------------------------------------------
        */

        $latestProducts = Product::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Map Data
        |--------------------------------------------------------------------------
        */

        $mapCountries = Country::select(
                'id',
                'name',
                'latitude',
                'longitude',
                'risk_level',
                'risk_score',
                'trade_index',
                'shipping_status'
            )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('dashboard', compact(
            'countries',
            'suppliers',
            'products',
            'users',

            'highRisk',
            'mediumRisk',
            'lowRisk',
            'averageRisk',

            'riskChart',

            'topRiskCountries',

            'latestCountries',
            'latestSuppliers',
            'latestProducts',

            'mapCountries'
        ));
    }

    public function analytics()
    {
        return view('analytics');
    }

    public function dashboardData()
    {
        return response()->json([

            'countries' => Country::count(),
            'suppliers' => Supplier::count(),
            'products'  => Product::count(),
            'users'     => User::count(),

            'highRisk'   => Country::where('risk_level', 'High')->count(),
            'mediumRisk' => Country::where('risk_level', 'Medium')->count(),
            'lowRisk'    => Country::where('risk_level', 'Low')->count(),

            'averageRisk' => round(Country::avg('risk_score'), 1),

            'riskChart' => [
                Country::where('risk_level', 'Low')->count(),
                Country::where('risk_level', 'Medium')->count(),
                Country::where('risk_level', 'High')->count(),
            ],

            'topRiskCountries' => Country::orderByDesc('risk_score')
                ->take(5)
                ->get(),

            'mapCountries' => Country::select(
                    'id',
                    'name',
                    'latitude',
                    'longitude',
                    'risk_level',
                    'risk_score',
                    'trade_index',
                    'shipping_status'
                )
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(),

        ]);
    }
}