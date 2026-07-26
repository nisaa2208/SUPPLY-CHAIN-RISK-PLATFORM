<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = collect();

        // High Risk Countries
        foreach (Country::where('risk_score', '>=', 80)->get() as $country) {
            $notifications->push([
                'icon' => 'fas fa-globe',
                'color' => 'danger',
                'title' => 'High Risk Country',
                'message' => $country->name . ' has a very high risk score (' . $country->risk_score . ').',
                'time' => now()->format('d M Y H:i'),
            ]);
        }

        // High Risk Suppliers
        foreach (Supplier::where('risk_score', '>=', 80)->get() as $supplier) {
            $notifications->push([
                'icon' => 'fas fa-truck',
                'color' => 'warning',
                'title' => 'Supplier Alert',
                'message' => $supplier->name . ' is classified as High Risk.',
                'time' => now()->format('d M Y H:i'),
            ]);
        }

        // High Risk Products
        foreach (Product::where('risk_score', '>=', 80)->get() as $product) {
            $notifications->push([
                'icon' => 'fas fa-box-open',
                'color' => 'info',
                'title' => 'Product Alert',
                'message' => $product->name . ' has a high supply chain risk.',
                'time' => now()->format('d M Y H:i'),
            ]);
        }

        return view('notifications.index', compact('notifications'));
    }
}