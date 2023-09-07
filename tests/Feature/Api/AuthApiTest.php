<?php

use App\Models\Setting;

/**
 * @param $data
 * @return void
 */
function findOrCreateSetting($data): void
{
    $setting = Setting::query()->first();
    if (!$setting) {
        Setting::query()->create([
            'title' => fake()->title,
            'current_user_id' => $data['user']['id'],
            'brear_token' => $data['token']
        ]);
    } else {
        $setting->brear_token = $data['token'];
        $setting->current_user_id = $data['user']['id'];
        $setting->save();
    }
}

it('register user', function () {
    $data = [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
        'password' => fake()->password,
    ];
    $response = $this->postJson("/api/v1/register", $data);
    findOrCreateSetting($response['data']);
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'user created successfully']);
});

//it('login user', function () {
//    $data = [
//        'email' => 'admin@admin.com',
//        'password' => 'admin',
//    ];
//    $response = $this->postJson("/api/v1/login", $data);
//    print_head($response);
//    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'login successfully']);
//});
//
//it('logout user', function () {
//    $response = $this->getJson("/api/v1/logout");
//    print_head($response);
//    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'logout successfully']);
//});
