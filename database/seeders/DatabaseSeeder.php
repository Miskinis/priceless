<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Whitecube\LaravelPrices\Models\Price;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call([
//            StoreSeeder::class,
////            ProductSeeder::class,
//        ]);

        $stores = Store::factory()->count(4)->create();
        $products = Product::factory()->count(4)->create();

        for ($i = 0; $i < $products->count(); $i++)
        {
            $product = $products[$i];

            $amount = 10.52 * ($i+1);

            for ($x = 0; $x < $stores->count(); $x++)
            {
                $store = $stores[$x];

                $productStore = ProductStore::create([
                    'store_id' => $store->id,
                    'product_id' => $product->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                for ($z = 0; $z < 12; $z++)
                {
                    $price = new Price(amount: rand($amount, $amount + 5) + rand(1, 100) / 100,
                        currency: 'EUR',
                        type: 'selling',
                        activated_at: now()->addMonths($i));
                    $price->update(['created_at' => now()->addMonths($z), 'updated_at' => now()->addMonths($z)]);
                    $productStore->price = $price;
                }
            }
        }

        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
         ]);
    }
}
