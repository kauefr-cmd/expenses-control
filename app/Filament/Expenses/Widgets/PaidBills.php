<?php

namespace App\Filament\Expenses\Widgets;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaidBills extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $month = $this->filters['month'] ?? DueMonthly::from(now()->format('F'))->value;
        $year  = $this->filters['year']  ?? now()->year;

        $paid = FixedExpense::where('month', $month)->where('year', $year)
                    ->where('status', ExpenseStatus::Paid->value)->sum('amount')
              + VariableExpense::where('month', $month)->where('year', $year)
                    ->where('status', ExpenseStatus::Paid->value)->sum('amount');

        return [
            Stat::make('Contas Pagas', 'R$ ' . number_format($paid, 2, ',', '.'))
                ->description('Contas já pagas do mês')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
