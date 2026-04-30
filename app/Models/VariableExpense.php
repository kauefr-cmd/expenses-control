<?php

namespace App\Models;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariableExpense extends Model
{
    protected $fillable = [
        'name', 'category_id', 'amount', 'due_day',
        'description', 'installments', 'current_installment',
        'installment_group_id', 'year', 'month', 'status'];

    protected $casts = [
        'month' => DueMonthly::class,
        'status' => ExpenseStatus::class
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
