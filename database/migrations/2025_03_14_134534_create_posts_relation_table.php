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
        Schema::create('posts_relation', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('post_id')->nullable()->index('fkpost');
            $table->integer('subcategory_id')->nullable()->index('fksubcategory');
            $table->integer('tag_id')->nullable()->index('fktag');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_relation');
    }
};
