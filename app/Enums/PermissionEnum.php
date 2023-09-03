<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum PermissionEnum: string
{
    use EnumDataListTrait;

    case super_admin = 'permission super admin';
    //
    case orders = 'permission orders';
    case products = 'permission products';
    case payments = 'permission payments';
    case users = 'permission users';
    case roles = 'permission roles';
}
