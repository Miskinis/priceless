<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-form :action="route('product-store.store')" method="POST">
                    @bind($productStore)
                    <x-form-input name="price" :label="__('Manual Price')" />
                    <x-form-input name="currency" :label="__('Currency')" />

                    <x-form-input name="url" :label="__('Product Url')" />
                    <x-form-input name="price_xpath" :label="__('Price XPATH')" />

                    <x-form-select name="product_id" :label="__('Product')" :options="$products" />
                    <x-form-select name="store_id" :label="__('Store')" :options="$stores" />

                    <x-form-submit />
                    @endbind
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
