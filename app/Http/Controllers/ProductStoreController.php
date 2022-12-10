<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductStoreRequest;
use App\Http\Requests\UpdateProductStoreRequest;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Whitecube\LaravelPrices\Models\Price;

class ProductStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('product-store.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $products = Product::all()->pluck('name', 'id');
        $stores = Store::all()->pluck('name', 'id');
        return view('product-store.create', compact(['products', 'stores']));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreProductStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['price'] = new Price(amount: $validated['price'],
            currency: $validated['currency'],
            type: 'selling',
            activated_at: now());
        $productStore = ProductStore::updateOrCreate([
            'product_id' => $validated['product_id'],
            'store_id' => $validated['store_id']
        ], [
            $validated['price']
        ]);
        $productStore->setPriceAttribute($validated['price']);
        Session::flash('success', 'Created Successful!');
        return redirect()->route('product-store.show', $productStore);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(ProductStore $productStore)
    {
        return view('product-store.show', compact('productStore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(ProductStore $productStore)
    {
        $products = Product::all()->pluck('name', 'id');
        $stores = Store::all()->pluck('name', 'id');
        return view('product-store.edit', compact(['productStore', 'products', 'stores']));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateProductStoreRequest $request, ProductStore $productStore)
    {
        $validated = $request->validated();
        $price = new Price(amount: $validated['price'],
            currency: $validated['currency'],
            type: 'selling',
            activated_at: now());
        unset($validated['price']);
        ProductStore::update($validated);
        $productStore->setPriceAttribute($price);
        Session::flash('success', 'Created Successful!');
        return redirect()->route('product-store.show', $productStore);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(ProductStore $productStore)
    {
        $productStore->delete();
        Session::flash('success', 'Successfully Deleted!');
        return redirect()->route('product-store.index');
    }
}
