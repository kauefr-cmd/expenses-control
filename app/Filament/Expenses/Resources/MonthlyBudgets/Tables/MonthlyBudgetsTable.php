<?php

namespace App\Filament\Expenses\Resources\MonthlyBudgets\Tables;

use App\Enums\DueMonthly;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MonthlyBudgetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('month')
                    ->label('Mês')
                    ->formatStateUsing(fn ($state) => $state->getLabel())
                    ->sortable(),

                TextColumn::make('year')
                    ->label('Ano')
                    ->sortable(),

                TextColumn::make('budget_amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('month')
                    ->label('Mês')
                    ->options(DueMonthly::class)
                    ->default(DueMonthly::from(now()->format('F'))->value),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
