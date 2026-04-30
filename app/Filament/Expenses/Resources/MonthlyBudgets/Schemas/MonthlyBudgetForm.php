<?php

namespace App\Filament\Expenses\Resources\MonthlyBudgets\Schemas;

use App\Enums\DueMonthly;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MonthlyBudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('month')
                    ->label('Mês')
                    ->required()
                    ->options(DueMonthly::class)
                    ->default(DueMonthly::from(now()->format('F'))->value),

                TextInput::make('year')
                    ->label('Ano')
                    ->required()
                    ->numeric()
                    ->default(now()->year),

                TextInput::make('budget_amount')
                    ->label('Valor')
                    ->required()
                    ->numeric()
                    ->prefix('R$'),
            ]);
    }
}
