<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;

class ExportController extends Controller
{
    /**
     * Export PDF (Print View)
     */
    public function exportPDF()
    {
        $countries = Country::orderBy('name')->get();
        $suppliers = Supplier::with('country')->orderBy('name')->get();
        $products = Product::with(['country', 'supplier'])->orderBy('name')->get();

        return view('exports.pdf', compact(
            'countries',
            'suppliers',
            'products'
        ));
    }

    /**
     * Export Excel (CSV)
     */
    public function exportExcel()
    {
        $filename = 'countries_report.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Country',
                'Region',
                'Risk Score',
                'Risk Level',
                'Trade Index',
                'Shipping Status'
            ]);

            foreach (Country::orderBy('name')->get() as $country) {

                fputcsv($file, [
                    $country->name,
                    $country->region,
                    $country->risk_score,
                    $country->risk_level,
                    $country->trade_index,
                    $country->shipping_status,
                ]);

            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}