<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

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

        $product = Product::create([
            'name' => 'PowerColor Radeon RX 6600 Fighter 8GB DDR6'
        ]);
        $store = Store::create([
            'name' => 'Baitukas.lt'
        ]);
        $price = new Price(amount: 291.90,
            currency: 'EUR',
            type: 'selling',
            activated_at: now());
        $productStore = ProductStore::updateOrCreate([
            'product_id' => $product->id,
            'store_id' => $store->id
        ], [
            'url' => 'https://www.kaina24.lt/p/powercolor-radeon-rx-6600-fighter-8gb-ddr6',
            'price_xpath' => '/html/body/div[1]/div[2]/div[2]/div[1]/div[2]/div[2]/div/div/div[1]/table/tbody/tr/td[5]/a/div/span[1]',
        ]);
        $productStore->setPriceAttribute($price);

        $store = Store::create([
            'name' => 'Pirmi.lt'
        ]);
        $price = new Price(amount: 294.37,
            currency: 'EUR',
            type: 'selling',
            activated_at: now());
        $productStore = ProductStore::updateOrCreate([
            'product_id' => $product->id,
            'store_id' => $store->id
        ], [
            'url' => 'https://www.kaina24.lt/p/powercolor-radeon-rx-6600-fighter-8gb-ddr6',
            'price_xpath' => '/html/body/div[1]/div[2]/div[2]/div[1]/div[2]/div[2]/div/div/div[2]/table/tbody/tr/td[5]/a/div/span[1]',
        ]);
        $productStore->setPriceAttribute($price);

        $store = Store::create([
            'name' => 'Sinerta.lt'
        ]);
        $price = new Price(amount: 294.66,
            currency: 'EUR',
            type: 'selling',
            activated_at: now());
        $productStore = ProductStore::updateOrCreate([
            'product_id' => $product->id,
            'store_id' => $store->id
        ], [
            'url' => 'https://www.kaina24.lt/p/powercolor-radeon-rx-6600-fighter-8gb-ddr6',
            'price_xpath' => '/html/body/div[1]/div[2]/div[2]/div[1]/div[2]/div[2]/div/div/div[3]/table/tbody/tr/td[5]/a/div/span[1]',
        ]);
        $productStore->setPriceAttribute($price);
    }
}
