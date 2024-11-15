<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  public function store()
  {
    $message = Message::create([
        'chat_id' => $request->chat_id,
        'sender_id' => auth()->id(),
        'reciever_id' => $request->reciever_id,
        'content' => $request->content,
    ]);
    
    broadcast(new MessageSent($message))->toOthers();

    return response()->json($message);

  }
}
