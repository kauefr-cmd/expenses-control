<?php

namespace App\Filament\Expenses\Resources\FixedExpenseTemplates\Pages;

use App\Filament\Expenses\Resources\FixedExpenseTemplates\FixedExpenseTemplateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFixedExpenseTemplate extends CreateRecord
{
    protected static string $resource = FixedExpenseTemplateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
