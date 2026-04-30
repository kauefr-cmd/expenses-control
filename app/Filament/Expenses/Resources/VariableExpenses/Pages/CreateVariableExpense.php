<?php

namespace App\Filament\Expenses\Resources\VariableExpenses\Pages;

use App\Filament\Expenses\Resources\VariableExpenses\VariableExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVariableExpense extends CreateRecord
{
    protected static string $resource = VariableExpenseResource::class;
}
