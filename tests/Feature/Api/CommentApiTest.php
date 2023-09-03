<?php

use App\Models\Comment;
use App\Models\Product;

it('add comment for product', function () {
    $product = Product::factory()->create();
    $data = [
        'body' => 'test comment',
    ];
    $response = $this->postJson("/api/v1/comments/store/{$product->id}", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'comment created successfully']);
    $this->assertDatabaseHas('products', ['id' => $product->id]);
});

it('add reply for comment', function () {
    $comment = Comment::factory()->create();
    $data = [
        'body' => 'test reply',
    ];
    $response = $this->postJson("/api/v1/comments/reply/{$comment->id}", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'reply created successfully']);
    $this->assertDatabaseHas('comments', ['id' => $comment->id]);
});
