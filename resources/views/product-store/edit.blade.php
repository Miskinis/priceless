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
                    <x-form-input name="price" label="Price" />
                    <x-form-input name="currency" label="Currency" />
                    <x-form-select name="product_id" :options="$products" />
                    <x-form-select name="store_id" :options="$stores" />

                    <x-form-submit />
                    @endbind
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
