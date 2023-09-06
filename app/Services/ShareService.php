<?php

namespace App\Services;

use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ShareService
{
    use FileUploadTrait;

    public const brear_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMTIyZTI2ZDEwNjBkNjJhZDJkZmQ1YmZhYzJiYWI2OGYxOTYxODcwNjM5NWUxYjRhOGY1ZTQ5OWFjZTY0ZDI2NWRkYjZjYmFhZDVkM2ZiYzQiLCJpYXQiOjE2OTM5ODQwMzUuMjM2NDQ0LCJuYmYiOjE2OTM5ODQwMzUuMjM2NDQ2LCJleHAiOjE3MjU2MDY0MzUuMjI3OTM0LCJzdWIiOiI3MTAiLCJzY29wZXMiOltdfQ.M_hhFo0l1U4dYjpDpwksyI8owaQvG-roIBTaSQNsrzZtJzkLgos2S0MRXUxU6WpytQ1dLNJm4J-l6Yd1MG_rVR8AHJvCspT-H8aU-cs_2AeuejTHRxI199cFjyil51VHPLPpVJ8K3xkeIBCCUrq4H5a7TL2TSep6BL8huk92rqgURDKIk2_gAYEwGYUFKsI7T7QLEssTxzqLJmAkh4vdqTwjR2XhKzmAFTuhw9-q-cjNVp4ENBE66eLhkcg2W_vCOpaEQ4PYNKL2oHi7K0WLldzQIG7Ekwk9EVUcWXQ2tcAb4XcUu9uSqjYa3Y9hVjMuX4rx-GF-bWgTBnIGfN9XjA3-S1wBYLG8jIcnN54DhwAatepL0chFihuyBmYcWz4P_txQrZMosnh7j9NvJOvFL2ThJctiIjqzcwRayGJc6TjmNaZTyz3G4LR_8g0z2GOSqVokxTzx0egqIGxAN32tmfmIvAscb1zQ0TZzRdvnOTX4Fjjy8pgqdeE2cKZkFv8clk499teNtoNTlU4q9zEzbYSHtX7dasEbFfTkugjU02jb3hxcKYFuKqt3FyrEkgzWY_sk6DOQafTuqrZTcSjpefpRrOH9ZXq4JLQWCj4b40DfpLpU3Z2oB80IQsqqOS08-auB4FIDno4aM2pW1v1iZxKOVCCDxZ8AjBMW9GB3LvY";

    public static function replaceNewLineWithTag($text): array|string
    {
        return str_replace(PHP_EOL, '<br/>', $text);
    }

    public static function sendInternalApiRequestAndGetResponse($setAuthHeaders = true, string $route = null, array $params = [], string $url = null, $method = 'get', $token = ShareService::brear_token): mixed
    {
        $request = Request::create(uri: $url ?? route($route, $params), method: $method, parameters: $params);

        if ($setAuthHeaders) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
        $request->headers->set('Accept', 'application/json');

        return json_decode(Route::dispatch($request)->getContent());
    }

    public static function sendHttpPostRequest($url, $data)
    {
        return json_decode(Http::acceptJson()->post('http://127.0.0.1:8000' . $url, $data));
    }

    public static function sendHttpPostRequestWithAuth($url, $data, $token)
    {
        return json_decode(
            Http::acceptJson()
                ->withHeader('Authorization', 'Bearer ' . $token)
                ->post('http://127.0.0.1:8000' . $url, $data)
        );
    }
}
