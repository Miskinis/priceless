<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    protected $casts = ['stores.pivot.id' => 'string'];

    public $timestamps = true;

    public function stores()
    {
        return $this->belongsToMany(Store::class)
            ->using(ProductStore::class)
            ->withPivot('price')
            ->withTimestamps();
    }
}
