<?php

namespace App\Services;

use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ShareService
{
    use FileUploadTrait;

    public const brear_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMWUxMmQ1Y2UyYzU0YWQwNDU4ZTE2MWI5MTY3ZTBjNTA3ZjI3OTkwNjhjYzk1ODg5YWM3Y2M1YzE1YTgyMTQyZDllNzlkNDdhMmE2YzNhZjQiLCJpYXQiOjE2OTM5MzMyNjAuMzQ0NTcxLCJuYmYiOjE2OTM5MzMyNjAuMzQ0NTczLCJleHAiOjE3MjU1NTU2NjAuMzM5NjExLCJzdWIiOiI0MiIsInNjb3BlcyI6W119.XxI1rTApbbWd_04yeK5iNZh7wcpy5XldM04fiR9sRroYYRLUIU0T9IuNZ5lps8PHzdlVe-O-UJavP9-a5mLKezZGv65GwdQejb_-l2LggmGmHrDjXxWMcrHTYXgCsDqgB1gpIVsKu4OV058kGqRxv1zGUWSe60kPwcI3xgV3bKunDILNnSekX7bGkzS4YxrjsW-bO526FKdtKSTawql_hxnBv1rYSAj_4ZU2IIUdLwcLX4RMgPTrUNfzN9F9QlVkkdoNu5TdMpYYHPFiOeI7ui_un5fIc9p12IpjfUDUuOLlRNHpH__7gOSPx7kWtbLezWMGU8YpqqYZ1VpTa0LMMvRca3PMrIKpSGg-3Q3RmjR7tHDye4S-GRU8FT6tzQ_EY5V8oxNQztZJHXgzbJMcWqxhmkieZanuOUvx53K-1ioruc4ZkrOFTM5b6esUmbbQNmfSCG9WtlQirjdruVyDDuWjQmCQDoCEajIJozp59ghogyGyXU61n_WeNt2E34kQ5h0Qmm6Lo7OXqmIOa0GM8e6J2KeIoUznFQCGAc9exoi2PDXP2sz-XVq1N9PwOyNjzt5pSg-slsjHYtcdQWLGdTGbW8nwN4Qt_V8_wk4HL49oESXkh1cHgFGbE3pLr3WDeNXWYS9hzsgu8E8Nd1zujaq7h4X3UVPGwQyjFORHU_c";
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

        return json_decode(Route::dispatch($request)->getContent(), true);
    }

    public static function sendHttpPostRequest($url, $data)
    {
        return json_decode(Http::acceptJson()->post('http://127.0.0.1:8001' . $url, $data));
    }
}
