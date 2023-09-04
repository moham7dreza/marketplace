<?php

it('register user', function () {
    $password = fake()->password;
    $data = [
        'name' => fake()->name,
        'email' => fake()->unique()->safeEmail,
        'password' => $password,
    ];
    $response = $this->postJson("/api/v1/register", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'user created successfully']);
});

it('login user', function () {
    $data = [
        'email' => 'admin@admin.com',
        'password' => 'admin',
    ];
    $response = $this->postJson("/api/v1/login", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'login successfully']);
});

it('logout user', function () {
    $response = $this->getJson("/api/v1/logout");
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'logout successfully']);
});
