<?php

namespace App\Http\Controllers\Api;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChallengeController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $challenges = Challenge::all();

        return response()->json($challenges);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $executor = User::find($request->input('executor'))->get();
        $author = User::find($request->input('author'))->get();

        $challenge = new Challenge();
        $challenge->name = $request->input('name');
        $challenge->executor()->associate($executor);
        $challenge->author()->associate($author);
        $challenge->save();

        return response()->json([
            'status' => JsonResponse::$statusTexts['200'],
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
