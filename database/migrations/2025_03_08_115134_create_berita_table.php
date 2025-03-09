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
        Schema::create('berita', function (Blueprint $table) {
            $table->integer('idBerita', true);
            $table->string('judul_berita', 50)->nullable();
            $table->dateTime('tgl_berita')->useCurrentOnUpdate()->default('0000-00-00 00:00:00');
            $table->char('author_id', 36)->nullable();
            $table->string('url_gambar')->nullable();
            $table->text('isi_berita')->nullable();
            $table->string('slug')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
