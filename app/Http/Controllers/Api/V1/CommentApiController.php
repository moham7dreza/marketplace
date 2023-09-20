<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;

class CommentApiController extends Controller
{
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }


    /**
     * @OA\Post(
     ** path="/api/v1/comments/store/{product}",
     *  tags={"Comment Module"},
     *   security={{"sanctum":{}}},
     *  description="save user comment for item",
     * *     @OA\Parameter(
     *         in="path",
     *         name="item",
     *         required=true,
     *         description="Enter item id",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *           @OA\Property(
     *                  property="parent_id",
     *                  description="comment parent id",
     *                  type="integer",
     *               ),
     *          @OA\Property(
     *                  property="body",
     *                  description="user comment text",
     *                  type="string",
     *           ),
     *       )
     * )
     * ),
     *   @OA\Response(
     *      response=200,
     *      description="Data saved",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     *
     */
    public function store(CommentRequest $request, Product $product): JsonResponse
    {
        $comment = $this->commentService->store($request, $product);
        return response()->json([
            'status' => 'success',
            'message' => 'comment created successfully',
            'data' => new CommentResource($comment),
        ], 201);
    }

    /**
     * @OA\Post(
     ** path="/api/v1/comments/reply/{comment}",
     *  tags={"Comment Module"},
     *   security={{"sanctum":{}}},
     *  description="store reply for comment",
     * *     @OA\Parameter(
     *         in="path",
     *         name="comment",
     *         required=true,
     *         description="Enter comment id",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *          @OA\Property(
     *                  property="body",
     *                  description="user comment text",
     *                  type="string",
     *           ),
     *       )
     * )
     * ),
     *   @OA\Response(
     *      response=200,
     *      description="Data saved",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     *
     */
    public function reply(CommentRequest $request, Comment $comment): JsonResponse
    {
        $reply = $this->commentService->reply($request, $comment);
        return response()->json([
            'status' => 'success',
            'message' => 'reply created successfully',
            'data' => new CommentResource($reply),
        ], 201);
    }
}
