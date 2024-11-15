<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function findOrCreateChat($user1_id, $user2_id)
    {
        $chat = Chat::whereHas('users', function($query) use ($user1_id, $user2_id) {
            $query->whereIn('user_id', [$user1_id, $user2_id]);
        })->first();

        if (!$chat) {
            $chat = Chat::create();
            $chat->users()->attach([$user1_id, $user2_id]);
        }

        return $chat;
    }

}
