<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\PathItem(path="/api")
 * @OA\Info(
 *   title="Marketplace Api Routes List",
 *   version="1.0.0"
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
