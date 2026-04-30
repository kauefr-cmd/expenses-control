<?php

namespace App\Filament\Expenses\Resources\MonthlyBudgets\Pages;

use App\Filament\Expenses\Resources\MonthlyBudgets\MonthlyBudgetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMonthlyBudget extends EditRecord
{
    protected static string $resource = MonthlyBudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
