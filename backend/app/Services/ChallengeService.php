<?php

namespace App\Services;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeService
{
    public const PHOTO_FOLDER = 'uploads/photo/';

    public function savePhoto(Challenge $challenge, Request $request): Challenge
    {
        if($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = self::PHOTO_FOLDER . time() . '.' . $extension;
            $file->move(self::PHOTO_FOLDER, $filename);
            $challenge->update(['photo_url' => $filename]);
            $challenge->save();
        }

        return $challenge;
    }
}
