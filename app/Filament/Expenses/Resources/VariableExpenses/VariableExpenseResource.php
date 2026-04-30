<?php

namespace App\Filament\Expenses\Resources\VariableExpenses;

use App\Filament\Expenses\Resources\VariableExpenses\Pages\CreateVariableExpense;
use App\Filament\Expenses\Resources\VariableExpenses\Pages\EditVariableExpense;
use App\Filament\Expenses\Resources\VariableExpenses\Pages\ListVariableExpenses;
use App\Filament\Expenses\Resources\VariableExpenses\Schemas\VariableExpenseForm;
use App\Filament\Expenses\Resources\VariableExpenses\Tables\VariableExpensesTable;
use App\Models\VariableExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VariableExpenseResource extends Resource
{
    protected static ?string $model = VariableExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Conta Variável';

    protected static ?string $pluralModelLabel = 'Contas Variáveis';

    public static function form(Schema $schema): Schema
    {
        return VariableExpenseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VariableExpensesTable::configure($table);
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
            'index' => ListVariableExpenses::route('/'),
            'create' => CreateVariableExpense::route('/create'),
            'edit' => EditVariableExpense::route('/{record}/edit'),
        ];
    }
}
