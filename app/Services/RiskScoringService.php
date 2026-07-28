<?php

namespace App\Services;

use App\Models\Country;

class RiskScoringService
{
    /**
     * Calculate Composite Supply Chain Risk Score for a Country based on weighted formula (PDF Page 4 & 8)
     * Risk Score = (Weather * 30%) + (Inflation * 20%) + (Political/News * 40%) + (Currency * 10%)
     */
    public function calculateCountryRisk(Country $country, array $extra = []): array
    {
        // 1. Weather Risk (Default from country shipping status or OpenMeteo)
        $weatherRisk = $extra['weather_risk'] ?? ($country->shipping_status === 'Critical' ? 85 : ($country->shipping_status === 'Delayed' ? 60 : 25));

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
                'weather_risk' => $weatherRisk,
                'weather_weight' => '30%',
                'inflation_risk' => round($inflationRisk),
                'inflation_weight' => '20%',
                'news_risk' => $newsRisk,
                'news_weight' => '40%',
                'currency_risk' => $currencyRisk,
                'currency_weight' => '10%',
            ]
        ];
    }
}
