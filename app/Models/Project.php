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
            'completion_date',
            'budget',
        ];
    
    
        public function reviews()
        {
            return $this->hasMany(Review::class);
        }

}

