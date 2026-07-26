<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    //=================================
    // DISPLAY ALL PRODUCTS
    //=================================

    public function index()
    {
        $products = Product::latest()->get();

        return view(
            'products.index',
            compact('products')
        );
    }



    //=================================
    // FORM CREATE PRODUCT
    //=================================

    public function create()
    {
        $countries = Country::all();

        $suppliers = Supplier::all();

        return view(
            'products.create',
            compact(
                'countries',
                'suppliers'
            )
        );
    }



    //=================================
    // STORE PRODUCT
    //=================================

    public function store(Request $request)
    {
        $request->validate(

            [

                'country_id'       => 'required',
                'supplier_id'      => 'required',
                'name'             => 'required',
                'category'         => 'required',
                'stock'            => 'required|numeric',
                'shipping_status'  => 'required',
                'risk_score'       => 'required|numeric',

            ],

            [

                'country_id.required'
                => 'Silahkan pilih Country.',

                'supplier_id.required'
                => 'Silahkan pilih Supplier.',

                'name.required'
                => 'Nama Product wajib diisi.',

                'category.required'
                => 'Category wajib diisi.',

                'stock.required'
                => 'Stock wajib diisi.',

                'stock.numeric'
                => 'Stock harus berupa angka.',

                'shipping_status.required'
                => 'Silahkan pilih Shipping Status.',

                'risk_score.required'
                => 'Risk Score wajib diisi.',

                'risk_score.numeric'
                => 'Risk Score harus berupa angka.',

            ]

        );


        Product::create(

            $request->all()

        );


        return redirect()
                ->route('products.index')
                ->with(
                    'success',
                    'Product berhasil ditambahkan.'
                );
    }




    //=================================
    // DETAIL PRODUCT
    //=================================

    public function show(Product $product)
    {
        return view(
            'products.show',
            compact('product')
        );
    }




    //=================================
    // FORM EDIT PRODUCT
    //=================================

    public function edit(Product $product)
    {
        $countries = Country::all();

        $suppliers = Supplier::all();


        return view(
            'products.edit',

            compact(

                'product',
                'countries',
                'suppliers'

            )
        );
    }




    //=================================
    // UPDATE PRODUCT
    //=================================

    public function update(
        Request $request,
        Product $product
    )
    {

        $request->validate(

            [

                'country_id'       => 'required',
                'supplier_id'      => 'required',
                'name'             => 'required',
                'category'         => 'required',
                'stock'            => 'required|numeric',
                'shipping_status'  => 'required',
                'risk_score'       => 'required|numeric',

            ]

        );


        $product->update(

            $request->all()

        );


        return redirect()
                ->route('products.index')
                ->with(
                    'success',
                    'Product berhasil diupdate.'
                );

    }




    //=================================
    // DELETE PRODUCT
    //=================================

    public function destroy(Product $product)
    {

        $product->delete();


        return redirect()
                ->route('products.index')
                ->with(
                    'success',
                    'Product berhasil dihapus.'
                );

    }

}