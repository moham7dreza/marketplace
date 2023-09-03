<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum PaymentGatewayEnum: int
{
    use EnumDataListTrait;

    case zarin_pal = 0;
}
