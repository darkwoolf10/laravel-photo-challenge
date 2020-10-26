<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

/**
 * @OA\Get(
 * path="/api/auth/user",
 * summary="Get user data",
 * description="Get user date from request",
 * operationId="getUser",
 * tags={"user"},
 * security={ {"bearer": {} }},
 *    @OA\RequestBody(
 *        required=false,
 *        description="Get user data.",
 *    ),
 *    @OA\Response(
 *       response=200,
 *       description="Success"
 *    )
 * )
 */
class UserController
{
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
