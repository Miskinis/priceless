<?php

namespace App\Tables;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\Formatters\DateFormatter;
use Okipa\LaravelTable\RowActions\DestroyRowAction;
use Okipa\LaravelTable\RowActions\EditRowAction;
use Okipa\LaravelTable\RowActions\ShowRowAction;
use Okipa\LaravelTable\Table;

class ProductsTable extends AbstractTableConfiguration
{
    protected function table(): Table
    {
        return Table::make()
            ->model(Product::class)
            ->rowActions(fn(Product $product) => [
                new ShowRowAction(route('product.show', $product)),
                new EditRowAction(route('product.edit', $product)),
                (new DestroyRowAction())
                    // Override the action default confirmation question
                    // Or set `false` if you do not want to require any confirmation for this action
                    ->confirmationQuestion('Are you sure you want to delete product ' . $product->name . '?')
                    // Override the action default feedback message
                    // Or set `false` if you do not want to trigger any feedback message for this action
                    ->feedbackMessage('Product ' . $product->name . ' has been deleted.'),
            ]);
    }

    protected function columns(): array
    {
        return [
            Column::make('id')->sortable()->title('Id'),
            Column::make('name')->sortable()->title('Name'),
//            Column::make('priceMajor')->sortable()->title('Price'),
//            Column::make('priceCurrency')->sortable()->title('Currency'),
            Column::make('updated_at')->format(new DateFormatter('d/m/Y H:i'))->sortable()->sortByDefault('desc')->title('Updated at'),
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
