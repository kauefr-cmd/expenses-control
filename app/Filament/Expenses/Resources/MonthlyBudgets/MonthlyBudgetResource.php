<?php

namespace App\Filament\Expenses\Resources\MonthlyBudgets;

use App\Filament\Expenses\Resources\MonthlyBudgets\Pages\CreateMonthlyBudget;
use App\Filament\Expenses\Resources\MonthlyBudgets\Pages\EditMonthlyBudget;
use App\Filament\Expenses\Resources\MonthlyBudgets\Pages\ListMonthlyBudgets;
use App\Filament\Expenses\Resources\MonthlyBudgets\Schemas\MonthlyBudgetForm;
use App\Filament\Expenses\Resources\MonthlyBudgets\Tables\MonthlyBudgetsTable;
use App\Models\MonthlyBudget;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MonthlyBudgetResource extends Resource
{
    protected static ?string $model = MonthlyBudget::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'MonthlyBudget';

    protected static ?string $modelLabel = 'Salário';

    protected static ?string $pluralModelLabel = 'Salários';

    public static function form(Schema $schema): Schema
    {
        return MonthlyBudgetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonthlyBudgetsTable::configure($table);
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
            'index' => ListMonthlyBudgets::route('/'),
            'create' => CreateMonthlyBudget::route('/create'),
            'edit' => EditMonthlyBudget::route('/{record}/edit'),
        ];
    }
}
