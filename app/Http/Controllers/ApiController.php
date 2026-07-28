<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;

use App\Services\RiskScoringService;
use App\Services\SentimentAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    /**
     * Legacy HTML view endpoint
     */
    public function countries()
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,region,population,currencies,flags');

        $countries = [];
        if ($response->successful()) {
            $countries = collect($response->json())
                ->map(function ($country) {
                    $currency = !empty($country['currencies']) ? implode(', ', array_keys($country['currencies'])) : '-';
                    return [
                        'name'       => $country['name']['common'] ?? '-',
                        'region'     => $country['region'] ?? '-',
                        'currency'   => $currency,
                        'population' => $country['population'] ?? 0,
                        'flag'       => $country['flags']['png'] ?? '',
                    ];
                })
                ->sortBy('name')
                ->values();
        }

        return view('api.countries', compact('countries'));
    }

    /**
     * REST API 1: GET /api/countries (PDF Page 9)
     */
    public function apiCountries()
    {
        $countries = Country::all()->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'code' => $c->code,
                'region' => $c->region,
                'gdp' => $c->gdp ?? '$1.0 Trillion',
                'inflation' => $c->inflation . '%',
                'population' => $c->population,
                'currency' => $c->currency ?? 'USD',
                'risk_score' => $c->risk_score,
                'risk_level' => $c->risk_level,
                'shipping_status' => $c->shipping_status,
                'coordinates' => ['lat' => $c->latitude, 'lng' => $c->longitude],
            ];
        });

        return response()->json([
            'status' => 'success',
            'total' => $countries->count(),
            'data' => $countries
        ]);
    }

    /**
     * REST API 2: GET /api/risk (PDF Page 9)
     */
    public function apiRisk()
    {
        $riskService = new RiskScoringService();
        $countries = Country::all();

        $riskData = $countries->map(function ($c) use ($riskService) {
            $calc = $riskService->calculateCountryRisk($c);
            return [
                'country' => $c->name,
                'code' => $c->code,
                'composite_risk_score' => $calc['total_risk'],
                'risk_level' => $calc['risk_level'],
                'breakdown' => $calc['breakdown']
            ];
        });

        return response()->json([
            'status' => 'success',
            'total' => $riskData->count(),
            'algorithm' => 'Weighted Risk Model (Weather 30% + Inflation 20% + News 40% + Currency 10%)',
            'data' => $riskData
        ]);
    }

    /**
     * REST API 3: GET /api/ports (PDF Page 9)
     */
    public function apiPorts()
    {
        $ports = Port::all();

        return response()->json([
            'status' => 'success',
            'total' => $ports->count(),
            'dataset' => 'World Port Index Dataset',
            'data' => $ports
        ]);
    }

    /**
     * REST API 4: GET /api/news (PDF Page 9)
     */
    public function apiNews()
    {
        $sentimentService = new SentimentAnalysisService();
        $sampleHeadlines = [
            'Global inflation increases while shipping exports decrease due to regional conflict.',
            'Port congestion eases in Singapore following trade deal agreement.',
            'Severe weather disaster delays cargo arrivals in North America.',
            'Economic recovery and stable trade growth boost European market confidence.',
            'Sanctions and supply shortage threaten Asian logistics network.'
        ];

        $newsData = collect($sampleHeadlines)->map(function ($title, $index) use ($sentimentService) {
            $analysis = $sentimentService->analyze($title);
            return [
                'id' => $index + 1,
                'headline' => $title,
                'category' => in_array($index, [0, 1]) ? 'Trade & Logistics' : 'Economy & Risk',
                'sentiment' => $analysis['sentiment'],
                'positive_percent' => $analysis['positive_percent'] . '%',
                'negative_percent' => $analysis['negative_percent'] . '%',
                'neutral_percent' => $analysis['neutral_percent'] . '%',
            ];
        });

        return response()->json([
            'status' => 'success',
            'engine' => 'Lexicon-Based Sentiment Analysis (PHP)',
            'data' => $newsData
        ]);
    }

    /**
     * REST API 5: GET /api/currency (PDF Page 9)
     */
    public function apiCurrency()
    {
        try {
            $res = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');
            if ($res->successful()) {
                $rates = collect($res->json('rates', []))->only(['IDR', 'EUR', 'GBP', 'JPY', 'SGD', 'MYR', 'CNY', 'AUD', 'CAD', 'KRW']);
                return response()->json([
                    'status' => 'success',
                    'base' => 'USD',
                    'rates' => $rates
                ]);
            }
        } catch (\Exception $e) {}

        return response()->json([
            'status' => 'success',
            'base' => 'USD',
            'rates' => [
                'IDR' => 15650.00,
                'EUR' => 0.92,
                'GBP' => 0.78,
                'JPY' => 154.50,
                'SGD' => 1.34,
                'CNY' => 7.23,
                'AUD' => 1.52,
                'KRW' => 1380.00
            ]
        ]);
    }
}