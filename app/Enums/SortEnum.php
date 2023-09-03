<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum SortEnum: int
{
    use EnumDataListTrait;

    case latest = 1;
    case oldest = 2;
    case cheapest = 3;
    case most_expensive = 4;
    case fastest_delivery = 5;
}
