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
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->char('author_id', 36)->index('fkauthor');
            $table->text('post_judul')->nullable();
            $table->dateTime('post_date')->nullable();
            $table->enum('post_category', ['B', 'A'])->nullable();
            $table->string('post_img', 255)->nullable();
            $table->longText('post_isi')->nullable();
            $table->enum('post_status', ['0', '1'])->nullable();
            $table->string('slug', 100)->nullable()->unique('slug_unique');
            $table->integer('views')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
