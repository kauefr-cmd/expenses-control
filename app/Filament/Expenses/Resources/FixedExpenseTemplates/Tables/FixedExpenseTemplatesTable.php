<?php

namespace App\Filament\Expenses\Resources\FixedExpenseTemplates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FixedExpenseTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nome'),

                TextColumn::make('amount')
                    ->money('BRL')
                    ->label('Valor')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable(),

                TextColumn::make('due_day')
                    ->numeric()
                    ->label('Dia do Vencimento')
                    ->sortable(),

                IconColumn::make('active')
                    ->label('Ativo')
                    ->boolean(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => $state->getColor())
                    ->formatStateUsing(fn($state) => $state->getLabel()),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
