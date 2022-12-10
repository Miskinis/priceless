<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Whitecube\LaravelPrices\HasPrices;

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
