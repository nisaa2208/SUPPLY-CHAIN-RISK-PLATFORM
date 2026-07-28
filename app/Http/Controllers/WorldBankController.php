<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WorldBankController extends Controller
{
    /**
     * Display World Bank API Economic Indicators Dashboard (PDF Spec Pages 2 & 3)
     * Indicators: GDP (NY.GDP.MKTP.CD), Inflation (FP.CPI.TOTL.ZG), Population (SP.POP.TOTL), Exports (NE.EXP.GNFS.CD), Imports (NE.IMP.GNFS.CD)
     */
    public function index(Request $request)
    {
        $indicator = $request->input('indicator', 'GDP');
        
        $indicatorsMap = [
            'GDP' => ['code' => 'NY.GDP.MKTP.CD', 'label' => 'Gross Domestic Product (GDP)', 'unit' => 'USD', 'icon' => 'fa-dollar-sign'],
            'INFLATION' => ['code' => 'FP.CPI.TOTL.ZG', 'label' => 'Tingkat Inflasi Tahunan', 'unit' => '%', 'icon' => 'fa-percentage'],
            'POPULATION' => ['code' => 'SP.POP.TOTL', 'label' => 'Total Populasi Negara', 'unit' => 'Jiwa', 'icon' => 'fa-users'],
            'EXPORTS' => ['code' => 'NE.EXP.GNFS.CD', 'label' => 'Nilai Ekspor Barang & Jasa', 'unit' => 'USD', 'icon' => 'fa-file-export'],
            'IMPORTS' => ['code' => 'NE.IMP.GNFS.CD', 'label' => 'Nilai Impor Barang & Jasa', 'unit' => 'USD', 'icon' => 'fa-file-import']
        ];

        $currentMeta = $indicatorsMap[$indicator] ?? $indicatorsMap['GDP'];
        $indicatorCode = $currentMeta['code'];

        $countries = [];

        try {
            $response = Http::timeout(6)->get(
                "https://api.worldbank.org/v2/country/all/indicator/{$indicatorCode}",
                [
                    'format'   => 'json',
                    'per_page' => 40,
                ]
            );

            if ($response->successful() && isset($response->json()[1])) {
                $json = $response->json()[1];
                $countries = collect($json)
                    ->filter(function ($item) {
                        return !empty($item['value']) && !empty($item['country']['value']);
                    })
                    ->take(25)
                    ->values();
            }
        } catch (\Exception $e) {}

        return view('api.worldbank', compact('countries', 'indicator', 'currentMeta', 'indicatorsMap'));
    }
}