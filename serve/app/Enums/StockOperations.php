<?php

namespace App\Enums;

enum StockOperations: string
{
    case IN = 'IN';
    case LOSE = 'lose';
    case ADJUSTMENT = 'adjustment';
}
