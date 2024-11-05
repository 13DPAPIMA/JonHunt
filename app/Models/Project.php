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
            'description',
            'niche',
            'completion_date',
            'budget',
        ];
    
    
        public function reviews()
        {
            return $this->hasMany(Review::class);
        }

        public function avatar()
        {
            return $this->hasOne(Avatar::class, 'id');
        }

        public function creator()
        {
            return $this->belongsTo(User::class, 'creator_id');
        }
        

}

