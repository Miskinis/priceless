<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\LaravelPrices\HasPrices;

class Product extends Model
{
    use HasFactory;
    use HasPrices;

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }
}
