<?php

namespace App\Enums;

enum DueMonthly: string
{
    case january = 'January';
    case february = 'February';
    case march = 'March';
    case april = 'April';
    case may = 'May';
    case june = 'June';
    case july  = 'July';
    case august  = 'August';
    case september = 'September';
    case october = 'October';
    case november = 'November';
    case december = 'December';

    public function getLabel():string
    {
        return match ($this) {
            self::january => 'Janeiro',
            self::february => 'Fevereiro',
            self::march => 'Março',
            self::april => 'Abril',
            self::may => 'Maio',
            self::june => 'Junho',
            self::july => 'Julho',
            self::august => 'Agosto',
            self::september => 'Setembro',
            self::october => 'Outubro',
            self::november => 'Novembro',
            self::december => 'Dezembro',
        };
    }
}
