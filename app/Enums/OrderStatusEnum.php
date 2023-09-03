<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum OrderStatusEnum: int
{
    use EnumDataListTrait;

    case not_checked = 0;
    case await_confirm = 1;
    case not_confirmed = 2;
    case confirmed = 3;
    case canceled = 4;
    case returned = 5;
}
