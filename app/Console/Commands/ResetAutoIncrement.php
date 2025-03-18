<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetAutoIncrement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-auto-increment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Auto-Increment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement("
            DELETE FROM posts_relation 
            WHERE post_id NOT IN (SELECT id FROM posts)
            OR tag_id NOT IN (SELECT id FROM posts_tag)
            OR subcategory_id NOT IN (SELECT id FROM posts_subcategory)
        ");

        $tables = ['posts', 'posts_tag', 'posts_subcategory'];

        foreach ($tables as $table) {

            // Simpan mapping ID lama ke ID baru
            DB::statement("SET @new_id = 0;");
            DB::statement("CREATE TEMPORARY TABLE temp_{$table} AS 
                SELECT id, (@new_id := @new_id + 1) AS new_id FROM $table ORDER BY id;");
            
            // Update tabel utama dengan ID baru
            DB::statement("UPDATE $table t 
                JOIN temp_{$table} temp ON t.id = temp.id 
                SET t.id = temp.new_id;");

            // Reset Auto-Increment
            DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
        }

        DB::statement("
            UPDATE posts_relation pr
            JOIN temp_posts tp ON pr.post_id = tp.id
            SET pr.post_id = tp.new_id;
        ");
        DB::statement("
            UPDATE posts_relation pr
            JOIN temp_posts_tag tt ON pr.tag_id = tt.id
            SET pr.tag_id = tt.new_id;
        ");
        DB::statement("
            UPDATE posts_relation pr
            JOIN temp_posts_subcategory ts ON pr.subcategory_id = ts.id
            SET pr.subcategory_id = ts.new_id;
        ");

        DB::statement("SET @new_id = 0;");
        DB::statement("UPDATE posts_relation SET id = (@new_id := @new_id + 1) ORDER BY id;");
        DB::statement("ALTER TABLE posts_relation AUTO_INCREMENT = 1;");

        // Hapus tabel sementara
        DB::statement("DROP TEMPORARY TABLE IF EXISTS temp_posts, temp_posts_tag, temp_posts_subcategory;");

        foreach (['posts', 'posts_tag', 'posts_subcategory', 'posts_relation'] as $table) {
            DB::statement("OPTIMIZE TABLE $table;");
        }

    }

}
