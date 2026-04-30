<?php

namespace App\Filament\Expenses\Resources\MonthlyBudgets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MonthlyBudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('month')
                    ->required()
                    ->numeric(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('budget_amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
