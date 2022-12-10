<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-form :action="route('product.update', $product)" method="PUT">
                    @bind($product)
                    <x-form-input name="name" label="Name" />

                    <x-form-submit />
                    @endbind
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
