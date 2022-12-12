<?php

namespace App\Http\Controllers;

use App\Charts\PriceChart;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductStore;
use Illuminate\Support\Facades\Session;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
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
        $product = Product::create($validated);
        Session::flash('success', 'Created Successful!');
        return redirect()->route('product.show', $product);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Product $product)
    {
        $chart = new PriceChart;

        foreach ($product->stores as $store) {
            $groups = $store->pivot
                ->prices()
                ->latest()
                ->selectRaw('created_at, round(amount / 100, 2) as amount')
                ->get()
                ->groupBy(function($item)
                {
                    return $item->created_at->format('M-Y');
                });
            $labels = [];
            foreach ($groups as $key => $value) {
                $labels[] = $key;
                $chart->dataset($store->name, 'bar', $value->pluck('amount'));
            }
            $chart->labels($labels);
        }

        return view('product.show', compact(['product', 'chart']));
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
