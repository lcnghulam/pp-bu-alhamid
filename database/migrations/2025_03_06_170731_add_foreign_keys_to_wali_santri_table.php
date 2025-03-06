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
        Schema::table('wali_santri', function (Blueprint $table) {
            $table->foreign(['idSantri'], 'fk_waliSantri_idSantri')->references(['id'])->on('santri')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wali_santri', function (Blueprint $table) {
            $table->dropForeign('fk_waliSantri_idSantri');
        });
    }
};
