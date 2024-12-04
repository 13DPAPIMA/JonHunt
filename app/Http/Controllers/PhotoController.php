<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        if (!$request->hasFile('photo') || !$request->file('photo')->isValid()) {
            return response()->json(['error' => 'No file uploaded or invalid file'], 400);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $oldAvatar = Avatar::where('user_id', $user->id)->first();

        if ($oldAvatar) {
            try {
                Cloudinary::destroy($oldAvatar->cloudinary_public_id);

                $oldAvatar->delete();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to delete old avatar', 'error' => $e->getMessage()], 500);
            }
        }

        $uploadedFile = $request->file('photo');
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
            'folder' => 'avatars',
        ]);

        $uploadedFileUrl = $result->getSecurePath();
        $publicId = $result->getPublicId();

        try {
            Avatar::create([
                'user_id' => $user->id,
                'photo_url' => $uploadedFileUrl,
                'cloudinary_public_id' => $publicId,
            ]);

            return response()->json(['message' => 'Photo uploaded successfully', 'photo_url' => $uploadedFileUrl]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Upload failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function getAvatar()
    {
        $user = Auth::user(); 

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $avatar = Avatar::where('user_id', $user->id)->first();

        if (!$avatar) {
            return response()->json(['message' => 'Avatar not found'], 404);
        }

        return response()->json(['photo_url' => $avatar->photo_url]); // Возвращаем URL аватара
    }

    public function deleteAvatar()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $avatar = Avatar::where('user_id', $user->id)->first();

    if (!$avatar) {
        return response()->json(['message' => 'No avatar to delete'], 404);
    }

    try {
        Cloudinary::destroy($avatar->cloudinary_public_id);

        $avatar->delete();

        return response()->json(['message' => 'Avatar deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to delete avatar', 'error' => $e->getMessage()], 500);
    }
}

}
