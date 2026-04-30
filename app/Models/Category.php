<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'color', 'icon'];

    public function fixedExpenses(): HasMany
    {
        return $this->hasMany(FixedExpense::class);
    }

    public function variableExpenses(): HasMany
    {
        return $this->hasMany(VariableExpense::class);
    }

    public function fixedExpenseTemplates(): HasMany
    {
        return $this->hasMany(FixedExpenseTemplate::class);
    }
}
