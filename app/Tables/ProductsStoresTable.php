<?php

namespace App\Tables;

use App\Models\ProductStore;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\Filters\RelationshipFilter;
use Okipa\LaravelTable\Formatters\DateFormatter;
use Okipa\LaravelTable\RowActions\DestroyRowAction;
use Okipa\LaravelTable\RowActions\EditRowAction;
use Okipa\LaravelTable\RowActions\ShowRowAction;
use Okipa\LaravelTable\Table;

class ProductsStoresTable extends AbstractTableConfiguration
{
    public int $product_id;
    public int $store_id;

    protected function table(): Table
    {
        return Table::make()->model(ProductStore::class)
            ->query(function(Builder $query)
            {
                if(isset($this->product_id))
                    $query->where('product_id', '=', $this->product_id);
                if(isset($this->store_id))
                    $query->where('store_id', '=', $this->store_id);
            })
            ->rowActions(fn(ProductStore $productStore) => [
                new ShowRowAction(route('product-store.show', $productStore)),
                new EditRowAction(route('product-store.edit', $productStore)),
                (new DestroyRowAction())
                    // Override the action default confirmation question
                    // Or set `false` if you do not want to require any confirmation for this action
                    ->confirmationQuestion('Are you sure you want to delete product-store?')
                    // Override the action default feedback message
                    // Or set `false` if you do not want to trigger any feedback message for this action
                    ->feedbackMessage('Product-Store has been deleted.'),
            ]);
    }

    protected function columns(): array
    {
        return [
            Column::make('priceMajor')->title('Price'),
            Column::make('priceCurrency')->title('Currency'),
            Column::make('productName')->title('Product'),
            Column::make('storeName')->title('Store'),
            Column::make('created_at')->format(new DateFormatter('d/m/Y H:i'))->sortable()->sortByDefault('desc')->title('Updated at'),
        ];
    }

    protected function results(): array
    {
        return [
            // The table results configuration.
            // As results are optional on tables, you may delete this method if you do not use it.
        ];
    }
}
