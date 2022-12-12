<?php

namespace App\Http\Controllers;

use App\Crawlers\PriceObserver;
use App\Http\Requests\StoreProductStoreRequest;
use App\Http\Requests\UpdateProductStoreRequest;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Store;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Whitecube\LaravelPrices\Models\Price;

class ProductStoreController extends Controller
{
    /**
     * Crawl the website content.
     * @return true
     */
    public function fetchContent($model, $url)
    {
        //# initiate crawler
        Crawler::create([RequestOptions::ALLOW_REDIRECTS => true, RequestOptions::TIMEOUT => 30])
            ->setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246')
            ->acceptNofollowLinks()
            ->ignoreRobots()
            // ->setParseableMimeTypes(['text/html', 'text/plain'])
            ->setCrawlObserver(new PriceObserver($model))
//            ->setMaximumResponseSize(1024 * 1024 * 2) // 2 MB maximum
            ->setTotalCrawlLimit(1) // limit defines the maximal count of URLs to crawl
            // ->setConcurrency(1) // all urls will be crawled one by one
            ->setDelayBetweenRequests(1000)
//            ->executeJavaScript()
            ->startCrawling($url);
        return true;
    }
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
            'price' => $validated['price'],
            'url' => $validated['url'],
            'price_xpath' => $validated['price_xpath'],
        ]);
//        $productStore->setPriceAttribute($validated['price']);
        Session::flash('success', 'Created Successful!');
        return redirect()->route('product-store.show', $productStore);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(ProductStore $productStore)
    {
        $this->fetchContent(ProductStore::first(), $productStore->url);
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
        $validated['price'] = new Price(amount: $validated['price'],
            currency: $validated['currency'],
            type: 'selling',
            activated_at: now());
//        unset($validated['price']);
        ProductStore::update($validated);
//        $productStore->setPriceAttribute($price);
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
