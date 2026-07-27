<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index()
    {
        $products = Product::with(['country', 'supplier'])
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.create', compact(
            'countries',
            'suppliers'
        ));
    }

    /**
     * Store product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id'      => 'required|exists:countries,id',
            'supplier_id'     => 'required|exists:suppliers,id',
            'name'            => 'required|max:255',
            'category'        => 'required|max:255',
            'stock'           => 'required|integer|min:0',
            'shipping_status' => 'required|in:Normal,Delayed,Critical',
            'risk_score'      => 'required|integer|min:0|max:100',
        ]);

        Product::create($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil ditambahkan.');
    }

    /**
     * Display detail.
     */
    public function show(Product $product)
    {
        $product->load(['country', 'supplier']);

        return view('products.show', compact('product'));
    }

    /**
     * Show edit form.
     */
    public function edit(Product $product)
    {
        $countries = Country::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.edit', compact(
            'product',
            'countries',
            'suppliers'
        ));
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'country_id'      => 'required|exists:countries,id',
            'supplier_id'     => 'required|exists:suppliers,id',
            'name'            => 'required|max:255',
            'category'        => 'required|max:255',
            'stock'           => 'required|integer|min:0',
            'shipping_status' => 'required|in:Normal,Delayed,Critical',
            'risk_score'      => 'required|integer|min:0|max:100',
        ]);

        $product->update($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil diperbarui.');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil dihapus.');
    }
}