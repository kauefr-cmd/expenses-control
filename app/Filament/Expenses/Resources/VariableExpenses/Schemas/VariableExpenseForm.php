<?php

namespace App\Filament\Expenses\Resources\VariableExpenses\Schemas;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VariableExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),

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
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(31)
                    ->required(),

                Textarea::make('description')
                    ->label('Descrição')
                    ->columnSpanFull(),

                Select::make('month')
                    ->label('Mês')
                    ->options(DueMonthly::class)
                    ->required(),

                TextInput::make('year')
                    ->label('Ano')
                    ->numeric()
                    ->default(now()->year)
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options(ExpenseStatus::class)
                    ->default(ExpenseStatus::Pending)
                    ->required(),

                TextInput::make('installments')
                    ->label('Parcelas')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->live(),
            ]);
    }
}
