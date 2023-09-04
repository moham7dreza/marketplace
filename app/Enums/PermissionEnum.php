<?php

namespace App\Enums;

use App\Traits\EnumDataListTrait;

enum PermissionEnum: string
{
    use EnumDataListTrait;

    case super_admin = 'super admin';
    //
    case orders_show = 'orders-show';
    case orders_change_status = 'orders-change-status';
    case products_create = 'products-create';
    case products_destroy = 'products-destroy';
    case payments_verify = 'payments-verify';
    case users = 'users';
    case roles = 'roles';
}
