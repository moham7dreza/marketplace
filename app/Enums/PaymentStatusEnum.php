<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum PaymentStatusEnum: int
{
    use EnumDataListTrait;

    case not_paid = 0;
    case paid = 1;
    case canceled = 2;
    case returned = 3;
}
