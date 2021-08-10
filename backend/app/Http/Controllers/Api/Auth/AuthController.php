<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

/**
 * @OA\SecurityScheme(
 *    securityScheme="bearer",
 *    type="http",
 *    scheme="bearer"
 * )
 * @OA\Post(
 * path="/api/auth/signup",
 * summary="Sign up",
 * description="Registration by name, email, password",
 * operationId="authRegistration",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="name", type="string", example="Jack"),
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *       @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
 *    )
 * ),
 * @OA\Response(
 *    response=400,
 *    description="Wrong credentials request",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, server don't can create new users. Please try again")
 *       )
 *    )
 * )
 *
 * @OA\Post(
 * path="/api/auth/login",
 * summary="Sign in",
 * description="Login by email, password",
 * operationId="authLogin",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *       @OA\Property(property="persistent", type="boolean", example=true),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *        @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *    )
 * )
 *
 * @OA\Get(
 * path="/api/auth/logout",
 * summary="Logout",
 * description="Logout user",
 * operationId="authLogout",
 * tags={"auth"},
 * security={ {"bearer": {} }},
 *    @OA\RequestBody(
 *        required=false,
 *         description="Logout user",
 *    ),
 *    @OA\Response(
 *    response=200,
 *    description="SUCCESS",
 *    @OA\JsonContent(
 *        @OA\Property(property="message", type="string", example="Success")
 *        )
 *    )
 * )
 */
class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        /** @var User $user */
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
        }

        setcookie('access_token', $tokenResult->accessToken,
            Carbon::now()->addWeeks(1)->getTimestamp(),
            '/login',
            'http::/localhost:3000'
        );

        return response()->json([
            'success' => true,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
