<?php

namespace App\Filament\Expenses\Widgets;

use App\Enums\DueMonthly;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MonthlyEvolution extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Evolução Mensal';

    protected function getData(): array
    {
        $year = $this->filters['year'] ?? now()->year;

        $monthMap = [
            1  => 'January', 2  => 'February', 3  => 'March',
            4  => 'April',   5  => 'May',       6  => 'June',
            7  => 'July',    8  => 'August',    9  => 'September',
            10 => 'October', 11 => 'November',  12 => 'December',
        ];

        $months = collect(range(1, 12));

        $fixed = $months->map(fn($m) =>
        FixedExpense::where('month', $monthMap[$m])
            ->where('year', $year)
            ->sum('amount')
        );

        $variable = $months->map(fn($m) =>
        VariableExpense::where('month', $monthMap[$m])
            ->where('year', $year)
            ->sum('amount')
        );

        $labels = $months->map(fn($m) =>
        now()->setMonth($m)->translatedFormat('M')
        );

        return [
            'datasets' => [
                [
                    'label'           => 'Gastos Fixos',
                    'data'            => $fixed->toArray(),
                    'borderColor'     => '#f59e0b',
                    'backgroundColor' => '#f59e0b20',
                    'fill'            => true,
                ],
                [
                    'label'           => 'Gastos Variáveis',
                    'data'            => $variable->toArray(),
                    'borderColor'     => '#ef4444',
                    'backgroundColor' => '#ef444420',
                    'fill'            => true,
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1000,
                    ],
                ],
            ],
        ];
    }
}
