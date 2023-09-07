<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ShareService
{
    use FileUploadTrait;

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

    public static function findSystemAdmin()
    {
        $admin = User::query()->where('email', 'admin@admin.com')->first();

        if (!$admin) {
            $admin = User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => 'admin',
            ]);
        }
        return $admin;
    }

    public static function findOrCreateToken()
    {
        $setting = Setting::query()->first();
        if (!$setting) {
            $registerUser = self::registerUser();
            $setting = self::createNewSetting($registerUser);
        }

        return $setting->brear_token;
    }

    /**
     * @return mixed
     */
    public static function registerUser(): mixed
    {
        $data = [
            'name' => 'admin',
            'email' => fake()->unique()->email,
            'password' => 'admin',
        ];
        return ShareService::sendHttpPostRequest('/api/v1/register', $data);
    }

    /**
     * @param mixed $registerUser
     * @return Builder|Model
     */
    public static function createNewSetting(mixed $registerUser): Builder|Model
    {
        return Setting::query()->create([
            'title' => fake()->title,
            'current_user_id' => $registerUser->data->user->id,
            'brear_token' => $registerUser->data->token,
        ]);
    }
}
