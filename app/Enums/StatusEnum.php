<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum StatusEnum:int
{
    use EnumDataListTrait;

    case inactive = 0;
    case active = 1;
}
