<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [

            [
                'name'=>'Indonesia',
                'code'=>'ID',
                'region'=>'Southeast Asia',
                'risk_score'=>25,
                'risk_level'=>'Low',
                'trade_index'=>88,
                'shipping_status'=>'Normal',
                'supply_status'=>'Normal',
                'latitude'=>-6.200000,
                'longitude'=>106.816666,
            ],

            [
                'name'=>'China',
                'code'=>'CN',
                'region'=>'East Asia',
                'risk_score'=>78,
                'risk_level'=>'Medium',
                'trade_index'=>95,
                'shipping_status'=>'Delayed',
                'supply_status'=>'Limited',
                'latitude'=>39.9042,
                'longitude'=>116.4074,
            ],

            [
                'name'=>'Japan',
                'code'=>'JP',
                'region'=>'East Asia',
                'risk_score'=>20,
                'risk_level'=>'Low',
                'trade_index'=>92,
                'shipping_status'=>'Normal',
                'supply_status'=>'Normal',
                'latitude'=>35.6762,
                'longitude'=>139.6503,
            ],

            [
                'name'=>'United States',
                'code'=>'US',
                'region'=>'North America',
                'risk_score'=>55,
                'risk_level'=>'Medium',
                'trade_index'=>97,
                'shipping_status'=>'Delayed',
                'supply_status'=>'Normal',
                'latitude'=>38.9072,
                'longitude'=>-77.0369,
            ],

            [
                'name'=>'Germany',
                'code'=>'DE',
                'region'=>'Europe',
                'risk_score'=>18,
                'risk_level'=>'Low',
                'trade_index'=>91,
                'shipping_status'=>'Normal',
                'supply_status'=>'Normal',
                'latitude'=>52.5200,
                'longitude'=>13.4050,
            ],

            [
                'name'=>'India',
                'code'=>'IN',
                'region'=>'South Asia',
                'risk_score'=>83,
                'risk_level'=>'High',
                'trade_index'=>74,
                'shipping_status'=>'Critical',
                'supply_status'=>'Disrupted',
                'latitude'=>28.6139,
                'longitude'=>77.2090,
            ],

            [
                'name'=>'Singapore',
                'code'=>'SG',
                'region'=>'Southeast Asia',
                'risk_score'=>12,
                'risk_level'=>'Low',
                'trade_index'=>99,
                'shipping_status'=>'Normal',
                'supply_status'=>'Normal',
                'latitude'=>1.3521,
                'longitude'=>103.8198,
            ],

            [
                'name'=>'South Korea',
                'code'=>'KR',
                'region'=>'East Asia',
                'risk_score'=>35,
                'risk_level'=>'Low',
                'trade_index'=>90,
                'shipping_status'=>'Normal',
                'supply_status'=>'Normal',
                'latitude'=>37.5665,
                'longitude'=>126.9780,
            ],

            [
                'name'=>'Vietnam',
                'code'=>'VN',
                'region'=>'Southeast Asia',
                'risk_score'=>49,
                'risk_level'=>'Low',
                'trade_index'=>80,
                'shipping_status'=>'Delayed',
                'supply_status'=>'Limited',
                'latitude'=>21.0278,
                'longitude'=>105.8342,
            ],

            [
                'name'=>'Thailand',
                'code'=>'TH',
                'region'=>'Southeast Asia',
                'risk_score'=>44,
                'risk_level'=>'Low',
                'trade_index'=>82,
                'shipping_status'=>'Normal',
                'supply_status'=>'Normal',
                'latitude'=>13.7563,
                'longitude'=>100.5018,
            ],

        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}