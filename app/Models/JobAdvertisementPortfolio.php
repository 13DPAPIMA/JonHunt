<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAdvertisementPortfolio extends Model
{
    use HasFactory;

    protected $table = 'job_advertisements_portfolio';

    protected $fillable = [
        'job_ad_id',
        'example_url',
        'example_public_id',
    ];

    // Связь: каждая запись портфолио относится к одному объявлению
    public function jobAd()
    {
        return $this->belongsTo(JobAdvertisement::class, 'job_ad_id');
    }
}
