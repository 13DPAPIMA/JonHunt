<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_url',
        'cloudinary_public_id',
        'user_id',
    ];

    // Определяем отношение между аватаром и пользователем
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function getPhotoUrlAttribute($value)
    {
        return asset($value); // Указывает полный путь к файлу
    }
}
