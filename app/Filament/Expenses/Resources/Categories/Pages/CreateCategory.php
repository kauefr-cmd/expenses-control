<?php

namespace App\Filament\Expenses\Resources\Categories\Pages;

use App\Filament\Expenses\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
