<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Country;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display Supplier List
     */
    public function index(Request $request)
    {
        $query = Supplier::with('country');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        $suppliers = $query->latest()->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('suppliers.create', compact('countries'));
    }

    /**
     * Store Supplier
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id'     => 'required|exists:countries,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:30',
            'address'        => 'required|string',
            'supply_status'  => 'required',
            'risk_score'     => 'required|numeric|min:0|max:100',
        ],[
            'country_id.required' => 'Silakan pilih Country.',
            'country_id.exists'   => 'Country tidak ditemukan.',
            'name.required'       => 'Nama Supplier wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format Email tidak valid.',
            'phone.required'      => 'Nomor Telepon wajib diisi.',
            'address.required'    => 'Alamat wajib diisi.',
            'supply_status.required' => 'Supply Status wajib dipilih.',
            'risk_score.required' => 'Risk Score wajib diisi.',
            'risk_score.numeric'  => 'Risk Score harus berupa angka.',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Detail Supplier
     */
    public function show(Supplier $supplier)
    {
        $supplier->load('country');

        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Edit Form
     */
    public function edit(Supplier $supplier)
    {
        $supplier->load('country');

        $countries = Country::orderBy('name')->get();

        return view('suppliers.edit', compact(
            'supplier',
            'countries'
        ));
    }

    /**
     * Update Supplier
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'country_id'     => 'required|exists:countries,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:30',
            'address'        => 'required|string',
            'supply_status'  => 'required',
            'risk_score'     => 'required|numeric|min:0|max:100',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Delete Supplier
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}