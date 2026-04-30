<?php

namespace App\Filament\Expenses\Resources\FixedExpenses\Schemas;

use App\Enums\ExpenseStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FixedExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label('Valor')
                    ->required()
                    ->numeric()
                    ->prefix('R$'),

                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->required(),

                TextInput::make('due_day')
                    ->label('Dia do vencimento')
                    ->required()
                    ->minValue(1)
                    ->maxValue(31)
                    ->numeric(),

                Select::make('status')
                    ->label('Status')
                    ->options(ExpenseStatus::class)
                    ->default(ExpenseStatus::Pending)
                    ->required(),

                Toggle::make('active')
                    ->default(true),
            ]);
    }
}
