<?php

namespace App\Models;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FixedExpense extends Model
{
    protected $fillable = [
        'name', 'amount', 'due_day', 'category_id',
        'active', 'year', 'status', 'month', 'fixed_expense_template_id'
    ];

    protected $casts = [
        'month' => DueMonthly::class,
        'status' => ExpenseStatus::class,
        'active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
