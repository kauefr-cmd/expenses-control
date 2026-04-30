<?php

namespace App\Filament\Expenses\Resources\VariableExpenses\Pages;

use App\Filament\Expenses\Resources\VariableExpenses\VariableExpenseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVariableExpense extends EditRecord
{
    protected static string $resource = VariableExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
