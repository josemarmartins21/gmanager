<?php

namespace App\Enums;

enum StockOperations: string
{
    case IN = 'Entrada';
    case LOSE = 'Perda';
    case ADJUSTMENT = 'Reajuste';
}
