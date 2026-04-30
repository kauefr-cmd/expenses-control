<?php

namespace App\Models;

use App\Enums\DueMonthly;
use App\Enums\ExpenseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FixedExpenseTemplate extends Model
{
    protected $fillable = [
        'name', 'amount', 'year',
        'due_day', 'status', 'category_id',
        'active'
    ];

    protected $casts = [
        'status' => ExpenseStatus::class,
        'active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
