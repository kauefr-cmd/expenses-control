<?php

namespace App\Filament\Expenses\Resources\FixedExpenses\Pages;

use App\Filament\Expenses\Resources\FixedExpenses\FixedExpenseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFixedExpense extends EditRecord
{
    protected static string $resource = FixedExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
