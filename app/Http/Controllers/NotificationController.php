<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = collect();

        // High Risk Countries
        foreach (Country::where('risk_score', '>=', 80)->get() as $country) {
            $notifications->push([
                'type' => 'danger',
                'icon' => 'fas fa-exclamation-triangle',
                'title' => 'High Risk Country',
                'message' => "{$country->name} memiliki Risk Score {$country->risk_score}.",
                'time' => $country->updated_at,
            ]);
        }

        // Critical Shipping Products
        foreach (Product::where('shipping_status', 'Critical')->get() as $product) {
            $notifications->push([
                'type' => 'warning',
                'icon' => 'fas fa-shipping-fast',
                'title' => 'Critical Shipping',
                'message' => "Produk {$product->name} memiliki status pengiriman Critical.",
                'time' => $product->updated_at,
            ]);
        }

        $notifications = $notifications->sortByDesc('time');

        return view('notifications.index', compact('notifications'));
    }
}