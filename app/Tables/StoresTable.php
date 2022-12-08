<?php

namespace App\Tables;

use App\Models\Store;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;
use Okipa\LaravelTable\Column;
use Okipa\LaravelTable\Formatters\DateFormatter;
use Okipa\LaravelTable\RowActions\DestroyRowAction;
use Okipa\LaravelTable\RowActions\EditRowAction;
use Okipa\LaravelTable\Table;

class StoresTable extends AbstractTableConfiguration
{
    protected function table(): Table
    {
        return Table::make()->model(Store::class)
            ->rowActions(fn(Store $store) => [
                new EditRowAction(route('store.edit', $store)),
                new DestroyRowAction(),
            ]);
    }

    protected function columns(): array
    {
        return [
            Column::make('id')->sortable(),
            Column::make('created_at')->format(new DateFormatter('d/m/Y H:i'))->sortable(),
            Column::make('updated_at')->format(new DateFormatter('d/m/Y H:i'))->sortable()->sortByDefault('desc'),
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
