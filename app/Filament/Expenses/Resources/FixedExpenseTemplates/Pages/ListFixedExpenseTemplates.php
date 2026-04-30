<?php

namespace App\Filament\Expenses\Resources\FixedExpenseTemplates\Pages;

use App\Filament\Expenses\Resources\FixedExpenseTemplates\FixedExpenseTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFixedExpenseTemplates extends ListRecords
{
    protected static string $resource = FixedExpenseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
