<?php

use App\Models\Comment;
use App\Models\Product;
use App\Services\ShareService;

it('add comment for product', function () {
    $product = Product::factory()->create();
    $data = [
        'body' => 'test comment',
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::findOrCreateToken(),
        'Accept' => 'application/json',
    ])->postJson("/api/v1/comments/store/{$product->id}", $data);
    //print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'comment created successfully']);
    $this->assertDatabaseHas('products', ['id' => $product->id]);
});

it('add reply for comment', function () {
    $comment = Comment::factory()->create();
    $data = [
        'body' => 'test reply',
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::findOrCreateToken(),
        'Accept' => 'application/json',
    ])->postJson("/api/v1/comments/reply/{$comment->id}", $data);
    //print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'reply created successfully']);
    $this->assertDatabaseHas('comments', ['id' => $comment->id]);
});
