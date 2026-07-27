<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::latest()->get();
        $suppliers = Supplier::with('country')->latest()->get();
        $products = Product::with(['country', 'supplier'])->latest()->get();

        return view('reports.index', compact(
            'countries',
            'suppliers',
            'products'
        ));
    }
}