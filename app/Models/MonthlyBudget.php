<?php

namespace App\Models;

use App\Enums\DueMonthly;
use Illuminate\Database\Eloquent\Model;

class MonthlyBudget extends Model
{
    protected $fillable = ['month', 'year', 'budget_amount'];

    protected $casts = [
        'month' => DueMonthly::class,
    ];
}
