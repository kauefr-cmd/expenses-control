<?php

namespace App\Filament\Expenses\Resources\FixedExpenseTemplates;

use App\Filament\Expenses\Resources\FixedExpenseTemplates\Pages\CreateFixedExpenseTemplate;
use App\Filament\Expenses\Resources\FixedExpenseTemplates\Pages\EditFixedExpenseTemplate;
use App\Filament\Expenses\Resources\FixedExpenseTemplates\Pages\ListFixedExpenseTemplates;
use App\Filament\Expenses\Resources\FixedExpenseTemplates\Schemas\FixedExpenseTemplateForm;
use App\Filament\Expenses\Resources\FixedExpenseTemplates\Tables\FixedExpenseTemplatesTable;
use App\Models\FixedExpenseTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FixedExpenseTemplateResource extends Resource
{
    protected static ?string $model = FixedExpenseTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Gastos Fixos';

    public static function form(Schema $schema): Schema
    {
        return FixedExpenseTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FixedExpenseTemplatesTable::configure($table);
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
            'index' => ListFixedExpenseTemplates::route('/'),
            'create' => CreateFixedExpenseTemplate::route('/create'),
            'edit' => EditFixedExpenseTemplate::route('/{record}/edit'),
        ];
    }
}
