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
        Schema::create('dr_c_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_token', 50)->unique();
            $table->text('concerns')->nullable();
            $table->text('report')->nullable();
            $table->enum('status', ['active', 'completed', 'archived'])->default('active');
            $table->integer('message_count')->default(0);
            $table->integer('tokens_used')->default(0);
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dr_c_sessions');
    }
};
