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
        Schema::create('wali_santri', function (Blueprint $table) {
            $table->integer('id', true);
            $table->char('nama', 50)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status', ['Ayah', 'Ibu', 'Lainnya'])->nullable();
            $table->integer('idSantri')->nullable()->index('fk_walisantri_idsantri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_santri');
    }
};
