<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        "SenderID",
        "ReceiverID",
        'Content',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'SenderID');
    }
 
    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'ReceiverID');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
