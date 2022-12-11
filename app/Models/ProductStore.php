<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Whitecube\LaravelPrices\HasPrices;
use Whitecube\LaravelPrices\Models\Price;

class ProductStore extends Pivot
{
    use HasPrices;
    use UuidTrait;

    protected $fillable = [
        'price',
        'product_id',
        'store_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function productName(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Product::where('id', '=', $this->product_id)->value('name'),
        );
    }

    public function storeName(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Store::where('id', '=', $this->store_id)->value('name'),
        );
    }

    /**
     * The current price model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function price()
    {
        return $this->morphOne(Price::class, 'priceable')->where('type', $this->getDefaultPriceType())->latest();
    }

    public function priceMajor(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->price()->first()?->amount / 100,
        );
    }

    public function priceCurrency(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->price()->first()?->currency,
        );
    }
}
