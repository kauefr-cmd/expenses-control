<?php

namespace App\Filament\Expenses\Resources\FixedExpenseTemplates\Pages;

use App\Filament\Expenses\Resources\FixedExpenseTemplates\FixedExpenseTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFixedExpenseTemplate extends EditRecord
{
    protected static string $resource = FixedExpenseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
