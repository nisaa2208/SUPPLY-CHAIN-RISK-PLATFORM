<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExchangeRateController extends Controller
{
    /**
     * Display Currency Impact Dashboard View
     */
    public function index(Request $request)
    {
        $base = strtoupper($request->input('base', 'USD'));
        $rates = $this->fetchRates($base);

        return view('api.exchange', compact('rates', 'base'));
    }

    /**
     * Live AJAX endpoint for real-time exchange rates
     */
    public function getLiveRates(Request $request)
    {
        $base = strtoupper($request->input('base', 'USD'));
        $rates = $this->fetchRates($base);

        return response()->json([
            'success' => true,
            'base' => $base,
            'updated_at' => now()->format('H:i:s'),
            'rates' => $rates
        ]);
    }

    /**
     * Fetch Live Exchange Rates from ExchangeRate API
     */
    private function fetchRates($base = 'USD')
    {
        try {
            $response = Http::timeout(4)->get("https://open.er-api.com/v6/latest/{$base}");

            if ($response->successful()) {
                $allRates = $response->json('rates', []);
                return collect($allRates)->only([
                    'USD', 'IDR', 'EUR', 'GBP', 'JPY', 'SGD', 'MYR', 'CNY', 'AUD', 'CAD', 'KRW', 'THB', 'SAR'
                ])->toArray();
            }
        } catch (\Exception $e) {}

        // Live fallback rates if API is temporarily busy
        $fallbackUsd = [
            'USD' => 1.00, 'IDR' => 15650.00, 'EUR' => 0.92, 'GBP' => 0.78, 
            'JPY' => 154.50, 'SGD' => 1.34, 'MYR' => 4.45, 'CNY' => 7.23, 
            'AUD' => 1.52, 'CAD' => 1.36, 'KRW' => 1380.00, 'THB' => 36.20, 'SAR' => 3.75
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