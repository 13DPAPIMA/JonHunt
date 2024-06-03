<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('ReviewID');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('UserID')->constrained('users');
            $table->text('ReviewedUserID')->constrained('users');
            $table->unsignedTinyInteger('Rating');
            $table->text('ReviewText')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
