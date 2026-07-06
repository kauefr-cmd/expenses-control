<?php

namespace App\Filament\Expenses\Widgets;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendingBills extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $month = $this->filters['month'] ?? DueMonthly::from(now()->format('F'))->value;
        $year  = $this->filters['year']  ?? now()->year;

        $pending = FixedExpense::where('month', $month)->where('year', $year)
                    ->where('status', ExpenseStatus::Pending->value)->sum('amount')
              + VariableExpense::where('month', $month)->where('year', $year)
                    ->where('status', ExpenseStatus::Pending->value)->sum('amount');

        return [
            Stat::make('Contas Pendentes', 'R$ ' . number_format($pending, 2, ',', '.'))
                ->description('Contas pendentes do mês')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}
