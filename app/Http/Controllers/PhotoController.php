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
        // Проверяем, был ли файл загружен и валиден
        if (!$request->hasFile('photo') || !$request->file('photo')->isValid()) {
            return response()->json(['error' => 'No file uploaded or invalid file'], 400);
        }

        // Получаем пользователя через Auth
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Проверяем, есть ли у пользователя старый аватар
        $oldAvatar = Avatar::where('user_id', $user->id)->first();

        // Если старый аватар существует, удаляем его из Cloudinary и базы данных
        if ($oldAvatar) {
            try {
                // Удаление файла из Cloudinary
                Cloudinary::destroy($oldAvatar->cloudinary_public_id);

                // Удаление записи из базы данных
                $oldAvatar->delete();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to delete old avatar', 'error' => $e->getMessage()], 500);
            }
        }

        // Загрузка нового файла в Cloudinary
        $uploadedFile = $request->file('photo');
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
            'folder' => 'avatars',
        ]);

        $uploadedFileUrl = $result->getSecurePath();
        $publicId = $result->getPublicId();

        // Сохраняем новый аватар в базе данных
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
        $user = Auth::user(); // Получаем текущего пользователя

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Ищем аватар пользователя
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

    // Ищем аватар пользователя
    $avatar = Avatar::where('user_id', $user->id)->first();

    if (!$avatar) {
        return response()->json(['message' => 'No avatar to delete'], 404);
    }

    try {
        // Удаление из Cloudinary
        Cloudinary::destroy($avatar->cloudinary_public_id);

        // Удаление записи из базы данных
        $avatar->delete();

        return response()->json(['message' => 'Avatar deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to delete avatar', 'error' => $e->getMessage()], 500);
    }
}

}
