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
        Schema::create('santri', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('nis')->nullable();
            $table->char('nama_lengkap', 50)->nullable();
            $table->date('ttl')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};
