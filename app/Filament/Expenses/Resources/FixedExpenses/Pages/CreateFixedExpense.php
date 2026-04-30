<?php

namespace App\Filament\Expenses\Resources\FixedExpenses\Pages;

use App\Filament\Expenses\Resources\FixedExpenses\FixedExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFixedExpense extends CreateRecord
{
    protected static string $resource = FixedExpenseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
