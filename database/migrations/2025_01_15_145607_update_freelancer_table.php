<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('freelancers', function (Blueprint $table) {
            // Удаляем поле portfolio (если оно существует)
            if (Schema::hasColumn('freelancers', 'portfolio')) {
                $table->dropColumn('portfolio');
            }

            // Удаляем поле hourly_rate (если оно существует)
            if (Schema::hasColumn('freelancers', 'hourly_rate')) {
                $table->dropColumn('hourly_rate');
            }

            // Заменяем experience (text) на два поля: experience_from и experience_to
            // Сначала удалим старое поле
            if (Schema::hasColumn('freelancers', 'experience')) {
                $table->dropColumn('experience');
            }

            // Теперь добавим два новых поля (год начала, год окончания)
            $table->integer('experience_from')->nullable();
            $table->integer('experience_to')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('freelancers', function (Blueprint $table) {
            // Откатываем изменения
            if (Schema::hasColumn('freelancers', 'experience_from')) {
                $table->dropColumn('experience_from');
            }
            if (Schema::hasColumn('freelancers', 'experience_to')) {
                $table->dropColumn('experience_to');
            }

            // Если хотим вернуть поля обратно:
            // $table->decimal('hourly_rate', 8, 2)->nullable();
            // $table->string('portfolio')->nullable();
            // $table->text('experience')->nullable();
        });
    }
};
