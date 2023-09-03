<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use App\Services\CommentService;

class CommentApiController extends Controller
{
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request, Product $product): \Illuminate\Http\JsonResponse
    {
        $comment = $this->commentService->store($request, $product);
        return response()->json([
            'status' => 'success',
            'message' => 'comment created successfully',
            'data' => new CommentResource($comment),
        ], 201);
    }

    public function reply(CommentRequest $request, Comment $comment): \Illuminate\Http\JsonResponse
    {
        $reply = $this->commentService->reply($request, $comment);
        return response()->json([
            'status' => 'success',
            'message' => 'reply created successfully',
            'data' => new CommentResource($reply),
        ], 201);
    }
}
