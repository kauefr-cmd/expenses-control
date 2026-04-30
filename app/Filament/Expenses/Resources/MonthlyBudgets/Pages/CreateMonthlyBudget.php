<?php

namespace App\Filament\Expenses\Resources\MonthlyBudgets\Pages;

use App\Filament\Expenses\Resources\MonthlyBudgets\MonthlyBudgetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMonthlyBudget extends CreateRecord
{
    protected static string $resource = MonthlyBudgetResource::class;
}
