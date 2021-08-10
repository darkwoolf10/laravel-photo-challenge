<?php

namespace App\Http\Controllers\Api;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class ChallengeController
 * @package App\Http\Controllers\Api
 */
class ChallengeController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $challenges = Challenge::with(['author', 'executor'])->get();

        return response()->json($challenges);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $executor = User::query()->find($request->executor)->first();
        //TODO::make get auth by jwt.
        $author = User::query()->find($request->author)->first();

        $challenge = new Challenge();
        $challenge->context = $request->task;
        $challenge->executor()->associate($executor);
        $challenge->author()->associate($author);
        $challenge->save();

        return response()->json([
            'message' => 'Challenge created',
        ]);
    }

    public function show(): JsonResponse
    {
        //TODO::just do it
    }

    public function edit(): JsonResponse
    {
        //TODO::just do it
    }

    public function delete(): JsonResponse
    {
        //TODO::just do it
    }
}
