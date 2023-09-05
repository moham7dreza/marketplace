<?php

namespace App\Services;

use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ShareService
{
    use FileUploadTrait;

    public const brear_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTdiZGNlMTRkOWZjYjU4MThhZjYwMjQ4YmFkM2Y5Mzg4MzA0ZGI4MjI5NzQ1NDg4ODg2MzU3ZDhjZTU1NjRkZmZhMjU2YjYyNjdkYWU2NjAiLCJpYXQiOjE2OTM4MTk2MTMuOTI3NDE4LCJuYmYiOjE2OTM4MTk2MTMuOTI3NDMsImV4cCI6MTcyNTQ0MjAxMy45MDkwNTgsInN1YiI6IjYyNSIsInNjb3BlcyI6W119.OfElwN2ku_K_QVEqK4-uVNoULOUAUPkeVRKQrhkB5BsI4oo4Ra1yhW7oCmVjmQzAyxOSWG5HJONX7uHQg6vRDoixTEqfo4nC7Zsk86MLsOGB2lnvvy9pEjs1AlxTBf_jh2P69V4LvJupXIFbghRLS1HAFelbBBu7SgwRPDarqgpR4JmC0fjCLTjdHSILL6Li9bDQbYoP1bd9DaX1ujQUdmfdO_SXzhx7sZzPSZWJj5WhxaveaJnWkPZbevEGij-df4IFOtWqjrs6aJ2FWfDvXp2ZkO2jmws1r4gJmF796WuTDTwKQ_Qa675Y0mzqKZjSQXvLQgNxIBfC9Pd5ke66Id7zMtX62DnnZx1wSCOJaci-NcQX_Iymk5Rk8JtP4xqfiWL2WVDz2gFwHCyp2uYI2AptJj5eyZhyIf748m1wcCChK2DDkxyIRJdUo_ksqumpFJnItqqyvdHMuvBRhboYgW2FL1iAZFVaaSdCvYGEjwsLlSX1Qt0ZHDvO88BjVK0Ft9RiykWwXW1ByANzBWVXHyUQBOF2_Zwl7Yb30m82M8iO_QR_spZ8EmMeFCvWlTni-57fe2rib_dnHDwEiWu5htGbgDZPDb3LFNxvAKlxyDAzQ47-9t9sTDJ6xZqLfZ87wJgY_FwiYcE7k9aCATZLbOJG6CoHzXv4pPcs7W190o8";

    public static function replaceNewLineWithTag($text): array|string
    {
        return str_replace(PHP_EOL, '<br/>', $text);
    }

    public static function sendInternalApiRequestAndGetResponse(string $route = null, array $params = [], string $url = null): mixed
    {
        $request = Request::create($url ?? route($route, $params), 'get');

        return json_decode(Route::dispatch($request)->getContent());
    }
}
