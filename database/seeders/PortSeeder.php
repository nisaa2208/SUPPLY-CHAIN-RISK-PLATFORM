<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Database\Seeder;

class PortSeeder extends Seeder
{
    /**
     * Seed global maritime ports database covering ALL 195 world countries.
     */
    public function run()
    {
        $explicitPorts = [
            // Indonesia
            [
                'name' => 'Pelabuhan Tanjung Priok',
                'country' => 'Indonesia',
                'city' => 'Jakarta',
                'latitude' => -6.1014,
                'longitude' => 106.8833,
                'port_code' => 'IDTPP',
                'status' => 'Active',
                'port_type' => 'Container & Cargo Terminal',
                'congestion_level' => 'Padat',
                'risk_level' => 'Medium Risk',
                'risk_score' => 45,
                'description' => 'Pelabuhan laut terbesar dan tersibuk di Indonesia yang menangani lebih dari 50% lalu lintas kargo maritim nasional.'
            ],
            [
                'name' => 'Pelabuhan Tanjung Perak',
                'country' => 'Indonesia',
                'city' => 'Surabaya',
                'latitude' => -7.2008,
                'longitude' => 112.7308,
                'port_code' => 'IDTPE',
                'status' => 'Active',
                'port_type' => 'Commercial Deepwater Port',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 22,
                'description' => 'Pintu gerbang utama distribusi logistik maritim untuk wilayah Indonesia bagian timur.'
            ],
            [
                'name' => 'Pelabuhan Belawan',
                'country' => 'Indonesia',
                'city' => 'Medan',
                'latitude' => 3.7847,
                'longitude' => 98.6942,
                'port_code' => 'IDBLW',
                'status' => 'Active',
                'port_type' => 'Export Cargo Terminal',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 28,
                'description' => 'Pelabuhan ekspor komoditas kelapa sawit dan karet terbesar di Pulau Sumatra.'
            ],

            // Singapore
            [
                'name' => 'Port of Singapore',
                'country' => 'Singapore',
                'city' => 'Singapore',
                'latitude' => 1.2644,
                'longitude' => 103.8400,
                'port_code' => 'SGSIN',
                'status' => 'Active',
                'port_type' => 'Global Transshipment Mega Hub',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 15,
                'description' => 'Hub alih muat (transshipment) kontainer tersibuk nomor dua di dunia dengan efisiensi tinggi.'
            ],

            // China
            [
                'name' => 'Port of Shanghai',
                'country' => 'China',
                'city' => 'Shanghai',
                'latitude' => 30.6274,
                'longitude' => 122.0628,
                'port_code' => 'CNSHA',
                'status' => 'Active',
                'port_type' => 'Automated Mega Container Port',
                'congestion_level' => 'Sangat Padat',
                'risk_level' => 'High Risk',
                'risk_score' => 72,
                'description' => 'Pelabuhan kontainer tersibuk di dunia dengan volume bongkar muat melebihi 47 juta TEU per tahun.'
            ],
            [
                'name' => 'Port of Ningbo-Zhoushan',
                'country' => 'China',
                'city' => 'Ningbo',
                'latitude' => 29.8782,
                'longitude' => 121.5492,
                'port_code' => 'CNNBO',
                'status' => 'Active',
                'port_type' => 'Bulk & Liquid Cargo Port',
                'congestion_level' => 'Padat',
                'risk_level' => 'Medium Risk',
                'risk_score' => 52,
                'description' => 'Pelabuhan dengan tonase kargo bulker terbesar di Asia.'
            ],
            [
                'name' => 'Port of Shenzhen',
                'country' => 'China',
                'city' => 'Shenzhen',
                'latitude' => 22.5004,
                'longitude' => 113.8828,
                'port_code' => 'CNSZX',
                'status' => 'Active',
                'port_type' => 'Electronics Export Port',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 30,
                'description' => 'Pusat ekspor barang manufaktur dan elektronik kawasan Pearl River Delta.'
            ],

            // Japan & South Korea
            [
                'name' => 'Port of Busan',
                'country' => 'South Korea',
                'city' => 'Busan',
                'latitude' => 35.1028,
                'longitude' => 129.0403,
                'port_code' => 'KRPUS',
                'status' => 'Active',
                'port_type' => 'Northeast Asia Logistics Hub',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 20,
                'description' => 'Hub logistik maritim utama Korea Selatan yang menghubungkan jalur Pasifik.'
            ],
            [
                'name' => 'Port of Yokohama',
                'country' => 'Japan',
                'city' => 'Yokohama',
                'latitude' => 35.4437,
                'longitude' => 139.6380,
                'port_code' => 'JPYOK',
                'status' => 'Active',
                'port_type' => 'Automotive & Industrial Port',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 18,
                'description' => 'Pelabuhan ekspor otomotif utama Jepang di Teluk Tokyo.'
            ],

            // Middle East & Africa
            [
                'name' => 'Jebel Ali Port',
                'country' => 'United Arab Emirates',
                'city' => 'Dubai',
                'latitude' => 24.9857,
                'longitude' => 55.0657,
                'port_code' => 'AEJEA',
                'status' => 'Active',
                'port_type' => 'Deepwater Middle East Hub',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 25,
                'description' => 'Pelabuhan buatan manusia terbesar di dunia dan pusat alih muat kawasan Timur Tengah.'
            ],
            [
                'name' => 'Port Said (Suez Canal)',
                'country' => 'Egypt',
                'city' => 'Port Said',
                'latitude' => 31.2653,
                'longitude' => 32.3019,
                'port_code' => 'EGPSD',
                'status' => 'Active',
                'port_type' => 'Canal Transit Gateway',
                'congestion_level' => 'Sangat Padat',
                'risk_level' => 'High Risk',
                'risk_score' => 78,
                'description' => 'Pintu masuk Terusan Suez di Laut Mediterania dengan tingkat kepadatan laluan kapal tinggi.'
            ],

            // Europe
            [
                'name' => 'Port of Rotterdam',
                'country' => 'Netherlands',
                'city' => 'Rotterdam',
                'latitude' => 51.9556,
                'longitude' => 4.1333,
                'port_code' => 'NLRTM',
                'status' => 'Active',
                'port_type' => 'European Primary Gateway',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 16,
                'description' => 'Pelabuhan laut terbesar di Eropa yang melayani koridor perdagangan Benua Eropa.'
            ],
            [
                'name' => 'Port of Hamburg',
                'country' => 'Germany',
                'city' => 'Hamburg',
                'latitude' => 53.5461,
                'longitude' => 9.9664,
                'port_code' => 'DEHAM',
                'status' => 'Active',
                'port_type' => 'Rail & Ocean Freight Hub',
                'congestion_level' => 'Padat',
                'risk_level' => 'Medium Risk',
                'risk_score' => 42,
                'description' => 'Gerbang ekspor industri manufaktur Jerman ke seluruh dunia.'
            ],

            // United States & Americas
            [
                'name' => 'Port of Los Angeles',
                'country' => 'United States',
                'city' => 'Los Angeles',
                'latitude' => 33.7423,
                'longitude' => -118.2673,
                'port_code' => 'USLAX',
                'status' => 'Active',
                'port_type' => 'Pacific Trade Gateway',
                'congestion_level' => 'Padat',
                'risk_level' => 'Medium Risk',
                'risk_score' => 58,
                'description' => 'Pelabuhan kontainer terbesar di Amerika Utara di Pantai Barat Samudra Pasifik.'
            ],
            [
                'name' => 'Port of Santos',
                'country' => 'Brazil',
                'city' => 'Santos',
                'latitude' => -23.9608,
                'longitude' => -46.3339,
                'port_code' => 'BRSSZ',
                'status' => 'Active',
                'port_type' => 'Agricultural Export Port',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 32,
                'description' => 'Pelabuhan ekspor kedelai, kopi, dan gula terbesar di Amerika Latin.'
            ],

            // Australia
            [
                'name' => 'Port of Sydney (Port Botany)',
                'country' => 'Australia',
                'city' => 'Sydney',
                'latitude' => -33.9712,
                'longitude' => 151.2267,
                'port_code' => 'AUSYD',
                'status' => 'Active',
                'port_type' => 'Oceania Trade Hub',
                'congestion_level' => 'Normal',
                'risk_level' => 'Low Risk',
                'risk_score' => 18,
                'description' => 'Pusat distribusi kargo dan kontainer maritim utama Australia.'
            ]
        ];

        // Seed explicit famous ports first
        foreach ($explicitPorts as $data) {
            Port::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // Now iterate over ALL 195 world countries to guarantee 100% port coverage across all nations
        $allCountries = Country::all();

        foreach ($allCountries as $country) {
            // Check if country already has ports
            $existingCount = Port::where('country', $country->name)->count();

            if ($existingCount < 2 && $country->latitude && $country->longitude) {
                // Generate Port 1: Main Port Terminal
                $portName1 = "Pelabuhan " . $country->name . " Terminal 1";
                Port::updateOrCreate(
                    ['name' => $portName1],
                    [
                        'name' => $portName1,
                        'country' => $country->name,
                        'city' => $country->name . " Coastal Hub",
                        'latitude' => round($country->latitude + (rand(-15, 15) / 100), 4),
                        'longitude' => round($country->longitude + (rand(-15, 15) / 100), 4),
                        'port_code' => strtoupper(substr($country->code, 0, 2)) . 'P1',
                        'status' => 'Active',
                        'port_type' => 'International Commercial Port',
                        'congestion_level' => ['Normal', 'Padat', 'Normal'][rand(0, 2)],
                        'risk_level' => ['Low Risk', 'Medium Risk', 'Low Risk'][rand(0, 2)],
                        'risk_score' => rand(15, 55),
                        'description' => "Pelabuhan niaga dan kontainer utama negara {$country->name} yang melayani ekspor-impor."
                    ]
                );

                // Generate Port 2: Cargo & Logistics Terminal
                $portName2 = "Pelabuhan " . $country->name . " Cargo Terminal";
                Port::updateOrCreate(
                    ['name' => $portName2],
                    [
                        'name' => $portName2,
                        'country' => $country->name,
                        'city' => $country->name . " Trade Zone",
                        'latitude' => round($country->latitude + (rand(-30, 30) / 100), 4),
                        'longitude' => round($country->longitude + (rand(-30, 30) / 100), 4),
                        'port_code' => strtoupper(substr($country->code, 0, 2)) . 'P2',
                        'status' => 'Active',
                        'port_type' => 'Bulk & Logistics Terminal',
                        'congestion_level' => ['Normal', 'Padat', 'Sangat Padat'][rand(0, 2)],
                        'risk_level' => ['Low Risk', 'Medium Risk', 'High Risk'][rand(0, 2)],
                        'risk_score' => rand(20, 75),
                        'description' => "Terminal pengiriman kargo dan alih muat maritim {$country->name}."
                    ]
                );
            }
        }
    }
}
