<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Сначала добавим колонку (если её ещё нет)
            if (!Schema::hasColumn('clients', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            // Затем добавим внешний ключ
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id'); // убираем FK вместе со столбцом
        });
    }
};
