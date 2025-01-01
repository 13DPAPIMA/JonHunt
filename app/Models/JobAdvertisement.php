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

    public function creatorUser()
    {
        return $this->belongsTo(User::class, 'creator_id'); // creator_id связывает объявление с пользователем
    }

}
