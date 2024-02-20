<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_activity', function (Blueprint $table) {
            $table->integer('no_activity')->primary();
            $table->string('id_user', 30)->foreign('id_user')->references('id_user')->on('users');
            $table->string('descripsi', 300);
            $table->string('status', 30);
            $table->string('menu_id', 3);
            $table->string('delete_mark', 1);
            $table->string('create_by', 30);
            $table->timestamp('create_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity');
    }
};
