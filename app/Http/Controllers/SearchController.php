<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $countries = collect();
        $suppliers = collect();
        $products = collect();

        if ($keyword) {

            $countries = Country::where('name', 'LIKE', "%{$keyword}%")
                ->orderBy('name')
                ->get();

            $suppliers = Supplier::where('name', 'LIKE', "%{$keyword}%")
                ->orderBy('name')
                ->get();

            $products = Product::where('name', 'LIKE', "%{$keyword}%")
                ->orderBy('name')
                ->get();
        }

        return view(
            'search.index',
            compact(
                'keyword',
                'countries',
                'suppliers',
                'products'
            )
        );
    }
}