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
        Schema::create('i_error_application', function (Blueprint $table) {
            $table->integer('error_id')->primary();
            $table->string('id_user', 30)->foreign('id_user')->references('id_user')->on('users');
            $table->string('error_date', 3);
            $table->string('modules', 100);
            $table->string('controller', 200);
            $table->string('function', 200);
            $table->string('error_line', 30);
            $table->string('error_message', 1000);
            $table->string('status', 30);
            $table->string('param', 300);
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
        Schema::dropIfExists('i_error_application');
    }
};
