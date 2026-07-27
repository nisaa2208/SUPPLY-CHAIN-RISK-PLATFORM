<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CountriesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Country::select(
            'name',
            'risk_level',
            'risk_score',
            'trade_index',
            'shipping_status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Country',
            'Risk Level',
            'Risk Score',
            'Trade Index',
            'Shipping Status'
        ];
    }
}