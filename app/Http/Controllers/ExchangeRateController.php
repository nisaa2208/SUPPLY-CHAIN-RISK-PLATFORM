<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExchangeRateController extends Controller
{
    /**
     * Display Currency Impact Dashboard View for All World Countries
     */
    public function index(Request $request)
    {
        $base = strtoupper($request->input('base', 'USD'));
        $rates = $this->fetchRates($base);

        return view('api.exchange', compact('rates', 'base'));
    }

    /**
     * Live AJAX endpoint for real-time exchange rates for all world currencies
     */
    public function getLiveRates(Request $request)
    {
        $base = strtoupper($request->input('base', 'USD'));
        $rates = $this->fetchRates($base);

        return response()->json([
            'success' => true,
            'base' => $base,
            'count' => count($rates),
            'updated_at' => now()->format('H:i:s'),
            'rates' => $rates
        ]);
    }

    /**
     * Fetch Live Exchange Rates for ALL World Currencies from Open Exchange Rates API
     */
    private function fetchRates($base = 'USD')
    {
        try {
            $response = Http::timeout(5)->get("https://open.er-api.com/v6/latest/{$base}");

            if ($response->successful()) {
                $allRates = $response->json('rates', []);
                if (!empty($allRates)) {
                    // Return all world currencies returned by the live API
                    return $allRates;
                }
            }
        } catch (\Exception $e) {}

        // Fallback comprehensive dataset of world currencies if API is temporarily unreachable
        $fallbackUsd = [
            'USD' => 1.00, 'IDR' => 15650.00, 'EUR' => 0.92, 'GBP' => 0.78, 'JPY' => 154.50,
            'SGD' => 1.34, 'MYR' => 4.45, 'CNY' => 7.23, 'AUD' => 1.52, 'CAD' => 1.36,
            'KRW' => 1380.00, 'THB' => 36.20, 'SAR' => 3.75, 'INR' => 83.50, 'BRL' => 5.45,
            'RUB' => 88.20, 'MXN' => 18.10, 'CHF' => 0.89, 'ZAR' => 18.20, 'AED' => 3.67,
            'NZD' => 1.64, 'TRY' => 32.80, 'PHP' => 58.60, 'VND' => 25450.00, 'EGP' => 47.80,
            'PKR' => 278.50, 'BDT' => 117.50, 'HKD' => 7.81, 'TWD' => 32.40, 'SEK' => 10.50,
            'NOK' => 10.60, 'DKK' => 6.87, 'PLN' => 3.98, 'HUF' => 365.00, 'CZK' => 23.10,
            'ILS' => 3.72, 'ARS' => 915.00, 'COP' => 4150.00, 'PEN' => 3.80, 'CLP' => 940.00,
            'NGN' => 1480.00, 'KWD' => 0.31, 'BHD' => 0.38, 'OMR' => 0.39, 'QAR' => 3.64
        ];

        if ($base === 'USD') return $fallbackUsd;

        $baseRate = $fallbackUsd[$base] ?? 1.00;
        $converted = [];
        foreach ($fallbackUsd as $code => $rate) {
            $converted[$code] = round($rate / $baseRate, 4);
        }
        return $converted;
    }
}