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
            $table->foreignId('SenderID')->constrained('users');
            $table->foreignId('ReceiverID')->constrained('users');
            $table->timestamp('SendDate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}

