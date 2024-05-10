<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
    class Project extends Model
    {
        use HasFactory;
    
        protected $fillable = [
            'title',
            'creator',
            'desc',
            'niche',
        ];
    
        // Здесь могут быть определены дополнительные отношения или методы модели, если необходимо
    }

