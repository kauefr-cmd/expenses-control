<?php

namespace App\Filament\Expenses\Pages;

use App\Enums\ExpenseStatus;
use App\Models\FixedExpense;
use App\Models\FixedExpenseTemplate;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Enums\DueMonthly;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function mount(): void
    {
        $this->filters = [
            'month' => DueMonthly::from(now()->format('F'))->value,
            'year'  => (string) now()->year,
        ];
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('month')
                            ->label('Mês')
                            ->options(DueMonthly::class)
                            ->default(DueMonthly::from(now()->format('F'))->value),

                        Select::make('year')
                            ->label('Ano')
                            ->options(function () {
                                $currentYear = now()->year;
                                return collect(range($currentYear - 2, $currentYear + 1))
                                    ->mapWithKeys(fn($year) => [$year => $year]);
                            })
                            ->default(now()->year)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_month')
                ->label('Gerar despesas do mês')
                ->icon('heroicon-o-calendar')
                ->schema([
                    Select::make('month')
                        ->label('Mês')
                        ->options(DueMonthly::class)
                        ->default(now()->month),

                    TextInput::make('year')
                        ->label('Ano')
                        ->numeric()
                        ->default(now()->year)
                        ->required(),
                ])
                ->action(function (array $data){
                    $templates =FixedExpenseTemplate::where('active', true)->get();

                    foreach ($templates as $template) {
                        FixedExpense::firstOrCreate(
                          [
                              'fixed_expense_template_id' => $template->id,
                              'month' => $data['month'],
                              'year' => $data['year'],
                          ],
                          [
                              'name' => $template->name,
                              'amount' => $template->amount,
                              'category_id' => $template->category_id,
                              'due_day' => $template->due_day,
                              'status' => ExpenseStatus::Pending,
                              'active' => true,
                          ]
                        );
                    }
                })
                ->successNotificationTitle('Despesas do mês geradas com sucesso')
                ->modalHeading('Gerar despesas do mês')
                ->modalSubmitActionLabel('Gerar Despesas'),
        ];
    }
}
