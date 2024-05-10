<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('PaymentID');
            $table->foreignId('ProjectID')->nullable()->constrained('projects');
            $table->foreignId('ClientID')->constrained('users');
            $table->foreignId('UserID')->constrained('users');
            $table->decimal('Amount', 10, 2);
            $table->string('PaymentStatus');
            $table->string('PaymentGatewayID');
            $table->timestamp('PaymentDate')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
