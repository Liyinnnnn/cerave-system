<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // If table already exists, just ensure required columns exist.
        if (Schema::hasTable('consultations')) {
            Schema::table('consultations', function (Blueprint $table) {
                if (!Schema::hasColumn('consultations', 'response')) {
                    $table->longText('response')->nullable()->after('concerns');
                }
                if (!Schema::hasColumn('consultations', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');
                }
            });
            return;
        }

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('concerns');
            $table->longText('response');
            $table->timestamps();
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('consultations')) {
            return;
        }

        Schema::table('consultations', function (Blueprint $table) {
            if (Schema::hasColumn('consultations', 'response')) {
                $table->dropColumn('response');
            }
            if (Schema::hasColumn('consultations', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
