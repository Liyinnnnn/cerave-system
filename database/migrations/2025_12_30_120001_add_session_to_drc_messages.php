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
        Schema::table('dr_c_messages', function (Blueprint $table) {
            $table->foreignId('session_id')->nullable()->after('user_id')->constrained('dr_c_sessions')->onDelete('cascade');
            $table->enum('message_type', ['user', 'assistant', 'system'])->default('user')->after('message');
            $table->json('recommended_products')->nullable()->after('response');
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dr_c_messages', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['session_id']);
            $table->dropColumn(['session_id', 'message_type', 'recommended_products']);
        });
    }
};
