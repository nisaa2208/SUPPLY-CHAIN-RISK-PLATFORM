<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RiskScoringService
{
    /**
     * Calculate Composite Supply Chain Risk Score for a Country based on weighted formula (PDF Page 4 & 8)
     * Risk Score = (Weather * 30%) + (Inflation * 20%) + (Political/News * 40%) + (Currency * 10%)
     */
    public function calculateCountryRisk(Country $country, array $extra = []): array
    {
        // 1. Weather Risk (Real-Time Open-Meteo API or Shipping Status)
        $weatherRisk = $extra['weather_risk'] ?? $this->getLiveWeatherRisk($country);

        // 2. Inflation Risk (Normalized 0-100% based on CPI inflation)
        $inflation = $country->inflation ?? 2.5;
        $inflationRisk = min(100, max(10, $inflation * 12));

        // 3. Political / News Sentiment Risk (0-100%)
        $newsRisk = $extra['news_risk'] ?? ($country->risk_score > 60 ? 75 : 35);

        // 4. Currency Volatility Risk (0-100%)
        $currencyRisk = $extra['currency_risk'] ?? ($country->currency === 'USD' || $country->currency === 'EUR' ? 20 : 45);

        // Weighted Risk Model Algorithm
        $totalRisk = round(
            ($weatherRisk * 0.30) +
            ($inflationRisk * 0.20) +
            ($newsRisk * 0.40) +
            ($currencyRisk * 0.10)
        );

        $riskLevel = 'Low Risk';
        $badgeClass = 'badge-success';

        if ($totalRisk >= 60) {
            $riskLevel = 'High Risk';
            $badgeClass = 'badge-danger';
        } elseif ($totalRisk >= 35) {
            $riskLevel = 'Medium Risk';
            $badgeClass = 'badge-warning';
        }

        return [
            'total_risk' => $totalRisk,
            'risk_level' => $riskLevel,
            'badge_class' => $badgeClass,
            'breakdown' => [
                'weather_risk' => round($weatherRisk),
                'weather_weight' => '30%',
                'inflation_risk' => round($inflationRisk),
                'inflation_weight' => '20%',
                'news_risk' => round($newsRisk),
                'news_weight' => '40%',
                'currency_risk' => round($currencyRisk),
                'currency_weight' => '10%',
            ]
        ];
    }

    /**
     * Fetch Live Weather Data from Open-Meteo API & Calculate Weather Risk (0-100%)
     */
    private function getLiveWeatherRisk(Country $country): float
    {
        if (!$country->latitude || !$country->longitude) {
            return $country->shipping_status === 'Critical' ? 85 : ($country->shipping_status === 'Delayed' ? 60 : 25);
        }

        try {
            $response = Http::timeout(3)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $country->latitude,
                'longitude' => $country->longitude,
                'current' => 'temperature_2m,precipitation,weather_code,wind_speed_10m',
                'timezone' => 'auto',
            ]);

            if ($response->successful()) {
                $current = $response->json('current') ?? [];
                $code = $current['weather_code'] ?? 0;
                $wind = $current['wind_speed_10m'] ?? 10;
                $precip = $current['precipitation'] ?? 0;

                // High severe weather (Thunderstorm, storm winds, torrential rain)
                if ($code >= 95 || $wind >= 38 || $precip >= 15) {
                    return 85;
                }
                // Moderate weather (Rain, high wind)
                if ($wind >= 20 || $precip >= 5 || in_array($code, [61, 63, 65, 80, 81])) {
                    return 55;
                }
                // Mild weather
                return 20;
            }
        } catch (\Exception $e) {
            Log::warning('Live Weather Risk Score fallback: ' . $e->getMessage());
        }

        return $country->shipping_status === 'Critical' ? 80 : ($country->shipping_status === 'Delayed' ? 55 : 25);
    }
}
