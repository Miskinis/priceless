<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\LaravelPrices\HasPrices;
use Whitecube\LaravelPrices\Models\Price;

class Product extends Model
{
    use HasFactory;
    use HasPrices;

    protected $fillable = [
        'name',
        'price',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function stores()
    {
        return $this->belongsToMany(Store::class);
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
