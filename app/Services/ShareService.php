<?php

namespace App\Services;

class ShareService
{
    public static function replaceNewLineWithTag($text): array|string
    {
        return str_replace(PHP_EOL, '<br/>', $text);
    }
}
