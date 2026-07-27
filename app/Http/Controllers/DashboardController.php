<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Statistics
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

        $highRisk   = Country::where('risk_score', '>=', 80)->count();
        $mediumRisk = Country::whereBetween('risk_score', [50, 79])->count();
        $lowRisk    = Country::where('risk_score', '<', 50)->count();

        /*
        |--------------------------------------------------------------------------
        | Shipping Statistics
        |--------------------------------------------------------------------------
        */

        $normalShipping   = Product::where('shipping_status', 'Normal')->count();
        $delayedShipping  = Product::where('shipping_status', 'Delayed')->count();
        $criticalShipping = Product::where('shipping_status', 'Critical')->count();

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
        | Recent Suppliers
        |--------------------------------------------------------------------------
        */

        $recentSuppliers = Supplier::with('country')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | World Map Data
        |--------------------------------------------------------------------------
        */

        $mapCountries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Risk Chart
        |--------------------------------------------------------------------------
        */

        $riskChart = [
            'labels' => ['Low', 'Medium', 'High'],
            'data' => [
                $lowRisk,
                $mediumRisk,
                $highRisk
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | Shipping Chart
        |--------------------------------------------------------------------------
        */

        $shippingChart = [
            'labels' => ['Normal', 'Delayed', 'Critical'],
            'data' => [
                $normalShipping,
                $delayedShipping,
                $criticalShipping
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | Dashboard Widgets
        |--------------------------------------------------------------------------
        */

        $shipments = Product::count();
        $warehouses = Country::count();
        $criticalAlerts = $highRisk;

        $dailyOrders = Product::count();
        $completedOrders = (int) round($products * 0.70);
        $pendingOrders = (int) round($products * 0.20);
        $cancelOrders = (int) round($products * 0.10);

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        $notifications = collect([
            (object)[
                'title' => 'System Status',
                'message' => 'Supply Chain Monitoring is running normally.'
            ],
            (object)[
                'title' => 'Risk Monitoring',
                'message' => $highRisk . ' High Risk Countries detected.'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Activities
        |--------------------------------------------------------------------------
        */

        $activities = collect([
            (object)[
                'title' => 'Administrator Login',
                'description' => 'Administrator logged into the system.',
                'created_at' => now(),
            ],
        ]);

        $recentTransactions = collect();

        return view('dashboard', compact(
            'countries',
            'suppliers',
            'products',
            'users',

            'highRisk',
            'mediumRisk',
            'lowRisk',

            'normalShipping',
            'delayedShipping',
            'criticalShipping',

            'topRiskCountries',
            'latestCountries',
            'recentSuppliers',
            'mapCountries',

            'riskChart',
            'shippingChart',

            'recentTransactions',
            'notifications',
            'activities',

            'shipments',
            'warehouses',
            'criticalAlerts',

            'dailyOrders',
            'completedOrders',
            'pendingOrders',
            'cancelOrders'
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

            'highRisk'   => Country::where('risk_score', '>=', 80)->count(),
            'mediumRisk' => Country::whereBetween('risk_score', [50,79])->count(),
            'lowRisk'    => Country::where('risk_score', '<', 50)->count(),

            'updated_at' => now()->format('d-m-Y H:i:s'),
        ]);
    }
}