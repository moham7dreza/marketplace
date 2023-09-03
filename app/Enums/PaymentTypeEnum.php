<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum PaymentTypeEnum: int
{
    use EnumDataListTrait;

    // pay with gateways
    case online = 0;
    // pay with cash in physical shop
    case offline = 1;
    // pay in user local
    case cash = 2;
}
