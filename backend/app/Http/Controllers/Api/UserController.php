<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController
{
    /**
     * @OA\Get(
     *   path="/api/users/all",
     *   summary="Get all users",
     *   description="Get all users data from request",
     *   operationId="getUser",
     *   tags={"user"},
     *   security={ {"bearer": {} }},
     *   @OA\RequestBody(
     *        required=false,
     *        description="Get user data.",
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="Success"
     *    )
     * )
     *
     * @return JsonResponse
     */
    public function users(Request $request): JsonResponse
    {
        $userId = auth()->guard('api')->user()->id;
        $users = User::query()->where('id', '!=', $userId)->get();

        return response()->json($users);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
