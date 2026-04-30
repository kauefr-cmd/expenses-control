<?php

namespace App\Filament\Expenses\Resources\VariableExpenses\Tables;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VariableExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable(),

                TextColumn::make('due_day')
                    ->label('Dia do vencimento')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('month')
                    ->label('Mês')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => $state->getColor())
                    ->formatStateUsing(fn($state) => $state->getLabel()),

                TextColumn::make('current_installment')
                    ->label('Parcela')
                    ->formatStateUsing(fn($state, $record) =>
                    $record->installments > 1
                        ? "{$state}/{$record->installments}"
                        : '-'
                    ),
            ])

            ->filters([
                SelectFilter::make('month')
                    ->label('Mês')
                    ->options(DueMonthly::class),
            ])

            ->recordActions([
                Action::make('toggle_status')
                    ->label(fn($record) => $record->status->getLabel())
                    ->color(fn($record) => $record->status->getColor())
                    ->icon(fn($record) => match($record->status) {
                        ExpenseStatus::Pending => 'heroicon-o-clock',
                        ExpenseStatus::Paid    => 'heroicon-o-check-circle',
                        ExpenseStatus::Overdue => 'heroicon-o-x-circle',
                    })
                    ->action(fn($record) => $record->update([
                        'status' => match($record->status) {
                            ExpenseStatus::Pending => ExpenseStatus::Paid,
                            ExpenseStatus::Paid    => ExpenseStatus::Pending,
                            ExpenseStatus::Overdue => ExpenseStatus::Paid,
                        }
                    ]))
                    ->button(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
