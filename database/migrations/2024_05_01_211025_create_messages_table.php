<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('MessageID');
            $table->text('Content');
            $table->foreignId('SenderID')->constrained('users')->onDelete('cascade');
            $table->foreignId('ReceiverID')->constrained('users')->onDelete('cascade');
            $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade');          
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}

