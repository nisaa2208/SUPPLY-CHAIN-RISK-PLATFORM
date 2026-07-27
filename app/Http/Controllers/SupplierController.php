<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::with('country')
            ->latest()
            ->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('suppliers.create', compact('countries'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id'     => 'required|exists:countries,id',
            'name'           => 'required|max:255',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|max:50',
            'address'        => 'nullable',
            'supply_status'  => 'required|in:Active,Inactive',
            'risk_score'     => 'required|integer|min:0|max:100',
        ]);

        Supplier::create($request->all());

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $countries = Country::orderBy('name')->get();

        return view('suppliers.edit', compact('supplier', 'countries'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'country_id'     => 'required|exists:countries,id',
            'name'           => 'required|max:255',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|max:50',
            'address'        => 'nullable',
            'supply_status'  => 'required|in:Active,Inactive',
            'risk_score'     => 'required|integer|min:0|max:100',
        ]);

        $supplier->update($request->all());

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}