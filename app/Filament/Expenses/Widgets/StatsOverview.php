<?php
namespace App\Filament\Expenses\Widgets;

use App\Enums\DueMonthly;
use App\Models\FixedExpense;
use App\Models\MonthlyBudget;
use App\Models\VariableExpense;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $month = $this->filters['month'] ?? DueMonthly::from(now()->format('F'))->value;
        $year  = $this->filters['year']  ?? now()->year;

        $salary = MonthlyBudget::where('month', $month)
            ->where('year', $year)
            ->value('budget_amount') ?? 0;

        $fixed = FixedExpense::where('month', $month)
            ->where('year', $year)
            ->sum('amount');

        $variable = VariableExpense::where('month', $month)
            ->where('year', $year)
            ->sum('amount');

        $total   = $fixed + $variable;
        $balance = $salary - $total;

        return [
            Stat::make('Salário', 'R$ ' . number_format($salary, 2, ',', '.'))
                ->description('Orçamento do mês')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Gastos Fixos', 'R$ ' . number_format($fixed, 2, ',', '.'))
                ->description('Contas fixas do mês')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('warning'),

            Stat::make('Gastos Variáveis', 'R$ ' . number_format($variable, 2, ',', '.'))
                ->description('Contas variáveis do mês')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('warning'),

            Stat::make('Total Gasto', 'R$ ' . number_format($total, 2, ',', '.'))
                ->description('Total do mês')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('danger'),

            Stat::make('Saldo', 'R$ ' . number_format($balance, 2, ',', '.'))
                ->description($balance >= 0 ? 'Saldo positivo' : 'Saldo negativo')
                ->descriptionIcon($balance >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($balance >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-scale'),
        ];
    }
}
