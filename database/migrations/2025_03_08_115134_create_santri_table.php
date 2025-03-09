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
            $table->integer('nis')->primary();
            $table->string('nama_lengkap', 50)->nullable();
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
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
