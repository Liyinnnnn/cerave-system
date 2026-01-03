<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Clean up any orphaned comments that reference non-existent users
        DB::statement('DELETE FROM comments WHERE user_id NOT IN (SELECT id FROM users)');

        Schema::table('comments', function (Blueprint $table) {
            // Drop the existing foreign key constraint if it exists
            if ($this->hasForeignKey('comments', 'comments_user_id_foreign')) {
                $table->dropForeign('comments_user_id_foreign');
            }
            
            // Make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Add the new constraint with set null
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Revert to the original constraint
            if ($this->hasForeignKey('comments', 'comments_user_id_foreign')) {
                $table->dropForeign('comments_user_id_foreign');
            }
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    private function hasForeignKey(string $table, string $constraint): bool
    {
        $database = DB::getDatabaseName();

        $result = DB::selectOne(
            "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? LIMIT 1",
            [$database, $table, $constraint]
        );

        return (bool) $result;
    }
};
