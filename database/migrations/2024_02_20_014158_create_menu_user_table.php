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
        Schema::create('menu_user', function (Blueprint $table) {
            $table->integer('no_seting')->primary();
            $table->string('id_user', 30)->foreign('id_user')->references('id_user')->on('users');
            $table->string('menu_id', 3)->foreign('menu_id')->references('menu_id')->on('menu');
            $table->string('delete_mark', 1);
            $table->string('create_by', 30);
            $table->timestamp('create_date');
            $table->string('update_by', 30);
            $table->timestamp('update_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_user');
    }
};
