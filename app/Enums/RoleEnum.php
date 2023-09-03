<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum RoleEnum: string
{
    use EnumDataListTrait;

    case admin = 'role admin';
}
