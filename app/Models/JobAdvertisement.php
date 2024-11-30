<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAdvertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'creator', 
        'examples',
        'price',
        'creator_id',
    ];

    // Relationship to the User who created the job ad
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator'); // 'creator' field references the user_id
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
