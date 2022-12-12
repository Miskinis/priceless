<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <p>Not all websites allow crawlers, while some filler them by provider. Not all shops will work with automated tracking.</p>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-form :action="route('product-store.store')" method="POST">
                    <x-form-input name="price" label="Manual Price" />
                    <x-form-input name="currency" label="Currency" />

                    <x-form-input name="url" label="Product Url" />
                    <x-form-input name="price_xpath" label="Price XPATH" />

                    <x-form-select name="product_id" :options="$products" />
                    <x-form-select name="store_id" :options="$stores" />

                    <x-form-submit />
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
