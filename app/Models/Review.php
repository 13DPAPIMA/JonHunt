<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'UserID',
        'ReviewedUserID',
        'Rating',
        'ReviewText',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'ReviewedUserID');
    }
}
