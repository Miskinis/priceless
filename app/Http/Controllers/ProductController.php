<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Whitecube\LaravelPrices\Models\Price;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['price'] = new Price(amount: $validated['price'], currency: 'EUR', type: 'selling');
        $product = Product::create();
        Session::flash('success', 'Created Successful!');
        return redirect()->route('product.show', $product);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $validated['price'] = new Price(
            amount: $validated['price'],
            currency: 'EUR',
            type: 'selling',
            activated_at: now());
        $product->update($validated);
        Session::flash('success', 'Update Successful!');
        return redirect()->route('product.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Session::flash('success', 'Successfully Deleted!');
        return redirect()->route('product.index');
    }
}
