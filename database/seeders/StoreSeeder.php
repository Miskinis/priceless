<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Whitecube\LaravelPrices\Models\Price;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 3; $i++) {
            Store::factory()
                ->count(2)
                ->hasAttached(
                    Product::factory(3)->recycle(Store::factory()->create()),
                    [
                        'price' => new Price(amount: rand(10, 50),
                            currency: 'EUR',
                            type: 'selling',
                            activated_at: Carbon::now()->subMonths(rand(1, 12))),
                        'created_at' => Carbon::now()->subMonths(rand(1, 12))
                    ]
                )
                ->create();
        }
    }
}
