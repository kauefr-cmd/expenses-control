<?php

namespace App\Filament\Expenses\Resources\FixedExpenses;

use App\Filament\Expenses\Resources\FixedExpenses\Pages\CreateFixedExpense;
use App\Filament\Expenses\Resources\FixedExpenses\Pages\EditFixedExpense;
use App\Filament\Expenses\Resources\FixedExpenses\Pages\ListFixedExpenses;
use App\Filament\Expenses\Resources\FixedExpenses\Schemas\FixedExpenseForm;
use App\Filament\Expenses\Resources\FixedExpenses\Tables\FixedExpensesTable;
use App\Models\FixedExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FixedExpenseResource extends Resource
{
    protected static ?string $model = FixedExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Conta fixa mensal';

    protected static ?string $pluralModelLabel = 'Contas fixas mensais';

    public static function form(Schema $schema): Schema
    {
        return FixedExpenseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FixedExpensesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFixedExpenses::route('/'),
            'edit' => EditFixedExpense::route('/{record}/edit'),
        ];
    }
}
