# Finance Control

A personal finance management application built with **Laravel 13** and **Filament 5**. It provides an admin-style panel to track monthly income, fixed and variable expenses, recurring bills, and budgets — all visualized through interactive charts and stats.

> **Live demo:** try the app at <http://finance-control.ddns.net/> using the credentials below:
>
> ```
> login:    user@email.com
> password: usertest
> ```

## Overview

Finance Control helps you keep an organized, month-by-month view of your personal finances. You set a monthly budget (e.g. your salary), register your fixed and variable expenses by category, and the dashboard shows you the totals, the remaining balance, and how spending evolves over time.

The application is structured around a dedicated **Expenses** Filament panel, accessible at `/expenses` after login.

## Features

- **Monthly Budget** — register the available budget (income/salary) for each month/year combination.
- **Categories** — organize expenses by category with a custom name, color, and icon.
- **Fixed Expense Templates** — define the recurring bills you have every month (rent, internet, subscriptions, etc.).
- **Monthly expense generation** — with one click on the dashboard, generate the fixed expenses for a given month/year from the active templates (uses `firstOrCreate` to avoid duplicates).
- **Fixed Expenses** — month-specific fixed bills, each with a status (`pending`, `paid`, `overdue`) and a due day.
- **Variable Expenses** — one-off or installment-based purchases (`installments`, `current_installment`, `installment_group_id`).
- **Dashboard with filters** — filter all widgets by month and year:
    - **Stats Overview**: salary, fixed total, variable total, total spent, and remaining balance.
    - **Expenses by Category**: pie chart breaking down spending per category (combining fixed and variable).
    - **Monthly Evolution**: 12-month line chart comparing fixed vs. variable spending across the selected year.

## Tech Stack

- **PHP 8.3+**
- **Laravel 13**
- **Filament 5.6** (admin panel, forms, tables, widgets, charts)
- **SQLite** (default; any Laravel-supported DB works)
- **Vite + Tailwind CSS 4** for assets

## Domain Model

| Model                  | Purpose                                                              |
|------------------------|----------------------------------------------------------------------|
| `MonthlyBudget`        | Available budget for a given `month` + `year`                        |
| `Category`             | Expense categorization (`name`, `color`, `icon`)                     |
| `FixedExpenseTemplate` | Blueprint for recurring fixed expenses                               |
| `FixedExpense`         | Materialized fixed expense for a specific month, linked to a template|
| `VariableExpense`      | One-off or installment-based purchase                                |

Two enums drive the workflow:

- `DueMonthly` — the twelve months (`January`..`December`) with Portuguese labels.
- `ExpenseStatus` — `pending`, `paid`, `overdue` (with color mapping for the UI).

## Getting Started

### Requirements

- PHP **8.3+** with the standard Laravel extensions (`pdo`, `pdo_sqlite`, `mbstring`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `dom`)
- Composer
- Node.js 20+

### Installation

```bash
git clone <your-repo-url> finance-control
cd finance-control

composer install
cp .env.example .env
php artisan key:generate

# Create the SQLite database file
touch database/database.sqlite

php artisan migrate

npm install
npm run build
```

Or use the bundled composer script which runs the full setup:

```bash
composer setup
```

### Running locally

The project ships with an all-in-one dev script that runs the PHP server, the queue worker, log tailing (`pail`), and Vite concurrently:

```bash
composer dev
```

Then open:

- App root: <http://localhost:8000>
- **Expenses panel**: <http://localhost:8000/expenses>

You will need to register/login on the Filament panel before you can use it.

### Tests

```bash
composer test
```

## Typical Workflow

1. **Create your categories** (Food, Housing, Transport, etc.).
2. **Set a Monthly Budget** for the current month.
3. **Register Fixed Expense Templates** for your recurring bills.
4. From the **Dashboard**, click **"Gerar despesas do mês"** to materialize the fixed expenses for the chosen month/year.
5. **Add Variable Expenses** as they happen (with installment support).
6. Update each expense status to `paid` when settled.
7. Check the dashboard widgets for an at-a-glance view of your finances.

## Project Structure

```
app/
├── Enums/                       # DueMonthly, ExpenseStatus
├── Filament/Expenses/
│   ├── Pages/Dashboard.php      # Filtered dashboard + month-generation action
│   ├── Resources/               # CRUD for each model
│   └── Widgets/                 # StatsOverview, ExpensesByCategory, MonthlyEvolution
├── Models/                      # Eloquent models
└── Providers/Filament/
    └── ExpensesPanelProvider.php
database/migrations/             # Schema definitions
```

## License

Released under the [MIT License](https://opensource.org/licenses/MIT).
