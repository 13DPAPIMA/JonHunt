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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_ad_id');
            $table->unsignedBigInteger('user_id');
            $table->text('requirements');
            $table->timestamps();
    
            if (Schema::hasTable('job_advertisements')) {
                $table->foreign('job_ad_id')->references('id')->on('job_advertisements')->onDelete('cascade');
            }
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
