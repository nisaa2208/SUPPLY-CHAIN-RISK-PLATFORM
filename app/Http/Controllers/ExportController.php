<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;

class ExportController extends Controller
{

    //=================================
    // EXPORT PDF
    //=================================

    public function exportPDF()
    {

        $countries = Country::all();

        $suppliers = Supplier::all();

        $products = Product::all();


        return view(

            'export.pdf',

            compact(

                'countries',
                'suppliers',
                'products'

            )

        );

    }



    //=================================
    // EXPORT EXCEL
    //=================================

    public function exportExcel()
    {

        $countries = Country::all();

        $suppliers = Supplier::all();

        $products = Product::all();


        return view(

            'export.excel',

            compact(

                'countries',
                'suppliers',
                'products'

            )

        );

    }

}