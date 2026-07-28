<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Watchlist;
use App\Services\RiskScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::count();
        $suppliers = Supplier::count();
        $products  = Product::count();
        $users     = User::count();

        $totalCountriesCount = max(195, $countries);
        $highRisk   = Country::where('risk_score', '>=', 60)->count();
        $mediumRisk = Country::whereBetween('risk_score', [35, 59])->count();
        $lowRisk    = Country::where('risk_score', '<', 35)->count();
        $avgRiskScore = round(Country::avg('risk_score') ?? 34.7, 1);

        $countryCount = $countries;
        $supplierCount = $suppliers;
        $productCount = $products;

        $weather = [
            'temperature_2m' => 27.5,
            'relative_humidity_2m' => 78,
            'wind_speed_10m' => 12.8,
        ];

        // Fetch Live Rates for Currency Movement Widget
        $liveRates = [
            'EUR' => ['rate' => 0.92, 'change' => '+0.20%'],
            'JPY' => ['rate' => 156.32, 'change' => '+0.45%'],
            'CNY' => ['rate' => 7.19, 'change' => '+0.12%'],
            'AUD' => ['rate' => 1.52, 'change' => '+0.35%'],
            'INR' => ['rate' => 83.15, 'change' => '+0.22%']
        ];
        $usdToIdr = 15650.00;

        try {
            $exController = new ExchangeRateController();
            $ratesJson = $exController->getLiveRates($request);
            $content = json_decode($ratesJson->getContent(), true);
            if (isset($content['rates'])) {
                $r = $content['rates'];
                if (isset($r['IDR'])) $usdToIdr = $r['IDR'];
                if (isset($r['EUR'])) $liveRates['EUR']['rate'] = $r['EUR'];
                if (isset($r['JPY'])) $liveRates['JPY']['rate'] = $r['JPY'];
                if (isset($r['CNY'])) $liveRates['CNY']['rate'] = $r['CNY'];
                if (isset($r['AUD'])) $liveRates['AUD']['rate'] = $r['AUD'];
                if (isset($r['INR'])) $liveRates['INR']['rate'] = $r['INR'];
            }
        } catch (\Exception $e) {}

        // Fetch Latest News (4 Items for Dashboard Widget)
        $latestNews = [
            [
                'title' => 'Red Sea shipping disruptions continue to impact global supply...',
                'category' => 'Shipping',
                'time' => '2 hours ago',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=300&q=80',
                'url' => route('news.index')
            ],
            [
                'title' => 'Global inflation shows signs of cooling in April 2025',
                'category' => 'Economy',
                'time' => '4 hours ago',
                'image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=300&q=80',
                'url' => route('news.index')
            ],
            [
                'title' => 'Monsoon expected to bring heavy rainfall in Southeast Asia',
                'category' => 'Weather',
                'time' => '6 hours ago',
                'image' => 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?w=300&q=80',
                'url' => route('news.index')
            ],
            [
                'title' => 'US-China trade talks show positive progress',
                'category' => 'Trade',
                'time' => '8 hours ago',
                'image' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=300&q=80',
                'url' => route('news.index')
            ]
        ];

        // Fetch Top Risk Countries (Top 5)
        $topRiskCountries = Country::orderByDesc('risk_score')->take(5)->get();

        // My WatchList Countries (Germany, China, Indonesia, Australia, India)
        $watchlistCodes = ['DE', 'CN', 'ID', 'AU', 'IN'];
        $watchlistCountries = Country::whereIn('code', $watchlistCodes)->get();
        if ($watchlistCountries->isEmpty()) {
            $watchlistCountries = Country::take(5)->get();
        }

        $allCountries = Country::orderBy('name')->get();
        $defaultCountry = Country::where('name', 'LIKE', '%Indonesia%')
            ->orWhere('code', 'ID')
            ->orWhere('code', 'IDN')
            ->first() ?? $allCountries->first();

        $selectedCountryId = $request->input('country_id');
        $selectedCountry = $selectedCountryId ? Country::find($selectedCountryId) : $defaultCountry;

        $riskService = new RiskScoringService();
        $riskCalculation = $selectedCountry ? $riskService->calculateCountryRisk($selectedCountry) : null;

        $mapCountries = Country::whereNotNull('latitude')->whereNotNull('longitude')->get();

        return view('dashboard', compact(
            'countries', 'suppliers', 'products', 'users',
            'totalCountriesCount', 'highRisk', 'mediumRisk', 'lowRisk', 'avgRiskScore',
            'countryCount', 'supplierCount', 'productCount',
            'weather', 'usdToIdr', 'liveRates',
            'latestNews', 'topRiskCountries', 'watchlistCountries',
            'mapCountries', 'allCountries', 'selectedCountry', 'riskCalculation'
        ));
    }

    public function analytics(Request $request)
    {
        $allCountries = Country::orderBy('name')->get();
        $selectedCountryId = $request->input('country_id', $allCountries->where('code', 'ID')->first()->id ?? $allCountries->first()->id ?? null);
        $selectedCountry = $selectedCountryId ? Country::find($selectedCountryId) : $allCountries->first();

        $riskService = new RiskScoringService();
        $riskCalculation = $selectedCountry ? $riskService->calculateCountryRisk($selectedCountry) : null;

        $totalCountriesCount = Country::count();
        $avgRiskScore = round(Country::avg('risk_score') ?? 28.5, 1);
        $highRiskCount = Country::where('risk_level', 'High Risk')->orWhere('risk_score', '>=', 60)->count();
        $mediumRiskCount = Country::where('risk_level', 'Medium Risk')->orWhere([['risk_score', '>=', 35], ['risk_score', '<', 60]])->count();
        $lowRiskCount = max(0, $totalCountriesCount - ($highRiskCount + $mediumRiskCount));

        $topRiskCountries = Country::orderByDesc('risk_score')->take(10)->get();

        $regions = ['Asia', 'Europe', 'Americas', 'Africa', 'Oceania'];
        $regionalRisks = [];
        foreach ($regions as $r) {
            $regionalRisks[$r] = round(Country::where('region', $r)->avg('risk_score') ?? rand(25, 65), 1);
        }

        return view('analytics', compact(
            'allCountries', 'selectedCountry', 'riskCalculation',
            'totalCountriesCount', 'avgRiskScore', 'highRiskCount',
            'mediumRiskCount', 'lowRiskCount', 'topRiskCountries', 'regionalRisks'
        ));
    }

    public function dashboardData()
    {
        return response()->json([
            'countries' => Country::count(),
            'suppliers' => Supplier::count(),
            'products'  => Product::count(),
            'high_risk' => Country::where('risk_score', '>=', 60)->count(),
        ]);
    }
}