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
            $table->unsignedBigInteger('client_id');       // Пользователь, купивший услугу
            $table->unsignedBigInteger('freelancer_id');   // Пользователь-фрилансер
            $table->enum('status', ['in_progress','completed','cancelled'])->default('in_progress');
            // Например, можно хранить "эскроу" логику, поле "deadline", "attachments" и т.д.
            $table->timestamps();
    
            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');
            // При желании связать client_id с user_id
            // При желании связать freelancer_id с user_id
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
