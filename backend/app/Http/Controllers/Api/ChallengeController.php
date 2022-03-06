<?php

namespace App\Http\Controllers\Api;

use App\Models\Challenge;
use App\Models\User;
use App\Services\ChallengeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChallengeController
{
    private ChallengeService $challengeService;

    public function __construct(ChallengeService $challengeService)
    {
        $this->challengeService = $challengeService;
    }

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
        $executor = User::query()->findOrFail($request->executor);
        //TODO::make get auth by jwt.
        $author = User::query()->findOrFail($request->author);

        $challenge = new Challenge();
        $challenge->context = $request->task;
        $challenge->executor()->associate($executor);
        $challenge->author()->associate($author);
        $challenge->save();

        return response()->json([
            'message' => 'Challenge created',
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $challenges = Challenge::query()->with(['author', 'executor'])->find($id);

        return response()->json($challenges);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function execute(Request $request): JsonResponse
    {
        $challenge = Challenge::query()->findOrFail($request->id);
        $filename = time().'.'.request()->img->getClientOriginalExtension();
        request()->img->move(public_path('images'), $filename);

        $challenge->photo = $filename;
        $challenge->save();

        return response()->json([
            'message' => 'Photo saved.',
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        $challenge = Challenge::query()->findOrFail($request->challengeId);
        $challenge->status = $request->status;
        $challenge->save();

        return response()->json([
            'message' => $challenge->status,
        ]);
    }

    public function edit(): JsonResponse
    {
        //TODO::just do it
    }

    public function delete(): JsonResponse
    {
        //TODO::just do it
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function setPhoto(Request $request): JsonResponse
    {
        /** @var Challenge $challenge */
        $challenge = Challenge::query()->findOrFail($request->challengeId);
        $this->challengeService->savePhoto($challenge, $request);

        return response()->json([
            'message' => 'Save photo.',
        ], 201);
    }
}
