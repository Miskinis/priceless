<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    protected $casts = ['products.pivot.id' => 'string'];

    public $timestamps = true;

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(ProductStore::class)
            ->withPivot('price')
            ->withTimestamps();
    }
}
