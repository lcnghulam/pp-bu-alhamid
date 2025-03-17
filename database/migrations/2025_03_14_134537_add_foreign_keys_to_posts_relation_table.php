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
        Schema::table('posts_relation', function (Blueprint $table) {
            $table->foreign(['post_id'], 'fkPost')->references(['id'])->on('posts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['subcategory_id'], 'fkSubCategory')->references(['id'])->on('posts_subcategory')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['tag_id'], 'fkTag')->references(['id'])->on('posts_tag')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts_relation', function (Blueprint $table) {
            $table->dropForeign('fkPost');
            $table->dropForeign('fkSubCategory');
            $table->dropForeign('fkTag');
        });
    }
};
