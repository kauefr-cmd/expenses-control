<?php

namespace App\Filament\Expenses\Resources\VariableExpenses\Pages;

use App\Enums\DueMonthly;
use App\Filament\Expenses\Resources\VariableExpenses\VariableExpenseResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CreateVariableExpense extends CreateRecord
{
    protected static string $resource = VariableExpenseResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $installments = max(1, (int) ($data['installments'] ?? 1));

        // o valor do enum month pode chegar como string ("July") ou como DueMonthly
        $monthValue = $data['month'] instanceof DueMonthly
            ? $data['month']->value
            : $data['month'];

        // ponto de partida: mês/ano selecionados no formulário
        $start = Carbon::createFromFormat('!F Y', $monthValue . ' ' . $data['year']);

        $first = null;
        $groupId = null;

        for ($i = 0; $i < $installments; $i++) {
            $date = $start->copy()->addMonths($i); // vira o ano automaticamente

            $record = static::getModel()::create([
                ...$data,
                'installments'         => $installments,
                'current_installment'  => $i + 1,
                'installment_group_id' => $groupId,
                'month'                => $date->format('F'), // ex.: "August" -> cast p/ DueMonthly
                'year'                 => $date->year,
                // 'amount' permanece igual em todas as linhas (valor por parcela)
            ]);

            if ($i === 0) {
                $first   = $record;
                $groupId = $record->getKey();               // agrupa as parcelas
                $record->update(['installment_group_id' => $groupId]);
            }
        }

        return $first; // Filament usa este registro para o redirect
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
