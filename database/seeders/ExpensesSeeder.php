<?php

namespace Database\Seeders;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use App\Models\Category;
use App\Models\FixedExpense;
use App\Models\FixedExpenseTemplate;
use App\Models\MonthlyBudget;
use App\Models\VariableExpense;
use Illuminate\Database\Seeder;

class ExpensesSeeder extends Seeder
{
    public function run(): void
    {
        // Categorias
        $categories = collect([
            'Moradia', 'Alimentação', 'Transporte',
            'Saúde', 'Lazer', 'Educação',
        ])->map(fn($name) => Category::create(['name' => $name]));

        // Orçamento (salário) dos últimos 3 meses
        foreach ([DueMonthly::february, DueMonthly::march, DueMonthly::april] as $month) {
            MonthlyBudget::create([
                'month'         => $month,
                'year'          => 2026,
                'budget_amount' => 5000.00,
            ]);
        }

        // Templates de gastos fixos
        $templates = [
            ['name' => 'Aluguel',    'amount' => 1200.00, 'due_day' => 10, 'category' => 'Moradia'],
            ['name' => 'Internet',   'amount' => 120.00,  'due_day' => 15, 'category' => 'Moradia'],
            ['name' => 'Academia',   'amount' => 100.00,  'due_day' => 5,  'category' => 'Saúde'],
            ['name' => 'Spotify',    'amount' => 22.00,   'due_day' => 20, 'category' => 'Lazer'],
            ['name' => 'Curso PHP',  'amount' => 150.00,  'due_day' => 1,  'category' => 'Educação'],
        ];

        foreach ($templates as $t) {
            FixedExpenseTemplate::create([
                'name'        => $t['name'],
                'amount'      => $t['amount'],
                'due_day'     => $t['due_day'],
                'category_id' => $categories->firstWhere('name', $t['category'])->id,
                'active'      => true,
                'status'      => ExpenseStatus::Pending,
            ]);
        }

        // Instâncias mensais (meses 2, 3 e 4 de 2026)
        foreach ([DueMonthly::february, DueMonthly::march, DueMonthly::april] as $month) {
            foreach (FixedExpenseTemplate::all() as $template) {
                FixedExpense::create([
                    'fixed_expense_template_id' => $template->id,
                    'name'        => $template->name,
                    'amount'      => $template->amount,
                    'category_id' => $template->category_id,
                    'due_day'     => $template->due_day,
                    'month'       => $month,
                    'year'        => 2026,
                    'active'      => true,
                    'status'      => $month !== DueMonthly::april ? ExpenseStatus::Paid : ExpenseStatus::Pending,
                ]);
            }
        }

        // Gastos variáveis
        $variableExpenses = [
            ['name' => 'Mercado',         'amount' => 450.00, 'due_day' => 5,  'category' => 'Alimentação', 'month' => DueMonthly::april],
            ['name' => 'Fatura Nubank',   'amount' => 780.00, 'due_day' => 10, 'category' => 'Lazer',       'month' => DueMonthly::april],
            ['name' => 'Consulta médica', 'amount' => 200.00, 'due_day' => 8,  'category' => 'Saúde',       'month' => DueMonthly::april],
            ['name' => 'Mercado',         'amount' => 380.00, 'due_day' => 3,  'category' => 'Alimentação', 'month' => DueMonthly::march],
            ['name' => 'Fatura Nubank',   'amount' => 650.00, 'due_day' => 10, 'category' => 'Lazer',       'month' => DueMonthly::march],
            ['name' => 'Mercado',         'amount' => 420.00, 'due_day' => 4,  'category' => 'Alimentação', 'month' => DueMonthly::february],
        ];

        foreach ($variableExpenses as $v) {
            VariableExpense::create([
                'name'                => $v['name'],
                'amount'              => $v['amount'],
                'due_day'             => $v['due_day'],
                'category_id'         => $categories->firstWhere('name', $v['category'])->id,
                'month'               => $v['month'],
                'year'                => 2026,
                'installments'        => 1,
                'current_installment' => 1,
                'status'              => $v['month'] !== DueMonthly::april ? ExpenseStatus::Paid : ExpenseStatus::Pending,
            ]);
        }
    }
}
