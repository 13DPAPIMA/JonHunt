<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_application_id');
            $table->unsignedBigInteger('client_id');       
            $table->unsignedBigInteger('freelancer_id');   
            $table->enum('status', ['in_progress','completed','cancelled','submitted'])->default('in_progress');
            $table->timestamps();
    
            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');

        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
