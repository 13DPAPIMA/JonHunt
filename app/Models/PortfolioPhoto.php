<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioPhoto extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'photo_url',
        'cloudinary_public_id',
        'freelancer_id',
    ]; 

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }
}
