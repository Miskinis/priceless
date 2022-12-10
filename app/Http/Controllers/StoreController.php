<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use Illuminate\Support\Facades\Session;
use Whitecube\LaravelPrices\Models\Price;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('store.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return  view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreStoreRequest $request)
    {
        $validated = $request->validated();
        $store = Store::create($validated);
        Session::flash('success', 'Created Successful!');
        return redirect()->route('store.show', $store);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Store $store)
    {
        return view('store.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Store $store)
    {
        return view('store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $validated = $request->validated();
        $store->update($validated);
        Session::flash('success', 'Update Successful!');
        return redirect()->route('store.show', $store);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Store $store)
    {
        $store->delete();
        Session::flash('success', 'Successfully Deleted!');
        return redirect()->route('store.index');
    }
}
