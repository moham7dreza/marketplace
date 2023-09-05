<?php

it('register user', function () {
    $data = [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
        'password' => fake()->password,
    ];
    $response = $this->postJson("/api/v1/register", $data);
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'user created successfully']);
});

it('login user', function () {
    $data = [
        'email' => 'admin@admin.com',
        'password' => 'admin',
    ];
    $response = $this->postJson("/api/v1/login", $data);
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'login successfully']);
});

it('logout user', function () {
    $response = $this->getJson("/api/v1/logout");
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'logout successfully']);
});
