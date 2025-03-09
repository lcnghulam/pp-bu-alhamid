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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->integer('idPengumuman', true);
            $table->string('judul_pengumuman', 50)->nullable();
            $table->dateTime('tgl_pengumuman')->nullable();
            $table->char('author_id', 36)->nullable();
            $table->string('url_gambar')->nullable();
            $table->text('isi_pengumuman')->nullable();
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
        Schema::dropIfExists('pengumuman');
    }
};
