<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'bio',
        'specialization',
        'experience',
        'hourly_rate',
        'portfolio',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
