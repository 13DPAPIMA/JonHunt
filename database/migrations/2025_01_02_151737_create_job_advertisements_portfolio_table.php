<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_advertisements_portfolio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_ad_id');
            $table->string('example_url');
            $table->string('example_public_id')->nullable(); 
            $table->timestamps();

            $table->foreign('job_ad_id')->references('id')->on('job_advertisements')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_advertisements_portfolio');
    }
};
