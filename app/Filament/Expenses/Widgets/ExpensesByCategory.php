<?php

namespace App\Filament\Expenses\Widgets;

use App\Enums\DueMonthly;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ExpensesByCategory extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Gastos por Categoria';

    protected function getData(): array
    {
        $month = $this->filters['month'] ?? DueMonthly::from(now()->format('F'))->value;
        $year = $this->filters['year'] ?? now()->year;

        $fixed = FixedExpense::with('category')
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->groupBy('category.name')
            ->map(fn($items) => $items->sum('amount'));

        $variable = VariableExpense::with('category')
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->groupBy('category.name')
            ->map(fn($items) => $items->sum('amount'));

        $merged = $fixed->mergeRecursive($variable)
            ->map(fn($val) => is_array($val) ? array_sum($val) : $val);

        return [
            'datasets' => [[
                'label' => 'Gastos',
                'data'  => $merged->values()->toArray(),
                'backgroundColor' => [
                    '#6366f1', // roxo
                    '#f59e0b', // amarelo
                    '#ef4444', // vermelho
                    '#10b981', // verde
                    '#3b82f6', // azul
                    '#ec4899', // rosa
                    '#8b5cf6', // violeta
                    '#14b8a6', // teal
                    '#f97316', // laranja
                    '#06b6d4', // ciano
                ],
                'borderColor' => '#1f2937',
                'borderWidth' => 2,
            ]],
            'labels' => $merged->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
