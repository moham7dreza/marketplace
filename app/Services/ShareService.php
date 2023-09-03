<?php

namespace App\Services;

use App\Traits\FileUploadTrait;

class ShareService
{
    use FileUploadTrait;

    public static function replaceNewLineWithTag($text): array|string
    {
        return str_replace(PHP_EOL, '<br/>', $text);
    }
}
