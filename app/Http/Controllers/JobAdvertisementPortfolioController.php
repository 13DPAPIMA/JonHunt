<?php

namespace App\Http\Controllers;

use App\Models\JobAdvertisementPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class JobAdvertisementPortfolioController extends Controller
{
    /**
     * Показать все примеры работ текущего пользователя
     */
    public function index()
    {
        // Получаем текущего пользователя
        $user = Auth::user();

        // Загружаем все записи из таблицы job_advertisements_portfolio для этого пользователя
        $portfolios = $user->portfolios; // Если прописали связь hasMany в модели User

        // Можно вернуть JSON (например, для API) или отдать Inertia/Vue/Blade
        return response()->json($portfolios);
    }

    /**
     * Создание (загрузка) нового примера работы
     */
    public function store(Request $request)
    {
        // Валидируем входящие данные
        $validator = Validator::make($request->all(), [
            'example' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Получаем текущего юзера
        $user = Auth::user();

        // Загружаем файл на Cloudinary
        $uploadedFile = $request->file('example');
        $result = Cloudinary::uploadFile($uploadedFile->getRealPath(), [
            'folder' => 'user-portfolio/' . $user->id,
        ]);

        // Сохраняем запись в БД
        $portfolio = new JobAdvertisementPortfolio();
        $portfolio->user_id = $user->id;
        $portfolio->example_url = $result->getSecurePath();
        $portfolio->example_public_id = $result->getPublicId();
        $portfolio->save();

        return redirect()->back()->with('success', 'Portfolio item uploaded successfully.');
    }

    /**
     * Отобразить конкретный элемент портфолио
     */
    public function show(JobAdvertisementPortfolio $portfolio)
    {
        // Проверим, имеет ли текущий пользователь право смотреть (если нужно):
        if (Auth::id() !== $portfolio->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($portfolio);
    }

    /**
     * Удаление
     */
    public function destroy(JobAdvertisementPortfolio $portfolio)
    {
        // Проверка прав:
        if (Auth::id() !== $portfolio->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Удаляем файл из Cloudinary
        if ($portfolio->example_public_id) {
            try {
                Cloudinary::destroy($portfolio->example_public_id);
            } catch (\Exception $e) {
                // Можно залогировать ошибку
            }
        }

        // Удаляем запись из БД
        $portfolio->delete();

        return redirect()->back()->with('success', 'Portfolio item deleted successfully.');
    }

    /**
     * Обновление (замена файла)
     */
    public function update(Request $request, JobAdvertisementPortfolio $portfolio)
    {
        // Проверка прав
        if (Auth::id() !== $portfolio->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Валидируем
        $validator = Validator::make($request->all(), [
            'example' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Если пришёл новый файл — значит, меняем
        if ($request->hasFile('example')) {
            // Удаляем старый
            if ($portfolio->example_public_id) {
                try {
                    Cloudinary::destroy($portfolio->example_public_id);
                } catch (\Exception $e) {
                    // Логируем при необходимости
                }
            }

            // Загружаем новый
            $uploadedFile = $request->file('example');
            $result = Cloudinary::uploadFile($uploadedFile->getRealPath(), [
                'folder' => 'user-portfolio/' . Auth::id(),
            ]);

            $portfolio->example_url = $result->getSecurePath();
            $portfolio->example_public_id = $result->getPublicId();
        }

        $portfolio->save();

        return redirect()->back()->with('success', 'Portfolio item updated successfully.');
    }
}
