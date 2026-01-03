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
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'report_status')) {
                $table->enum('report_status', ['draft', 'pending_approval', 'approved', 'rejected'])->default('draft')->after('status');
            }
            if (!Schema::hasColumn('appointments', 'report_submitted_at')) {
                $table->timestamp('report_submitted_at')->nullable()->after('report_status');
            }
            if (!Schema::hasColumn('appointments', 'report_submitted_by')) {
                $table->foreignId('report_submitted_by')->nullable()->constrained('users')->onDelete('set null')->after('report_submitted_at');
            }
            if (!Schema::hasColumn('appointments', 'report_approved_at')) {
                $table->timestamp('report_approved_at')->nullable()->after('report_submitted_by');
            }
            if (!Schema::hasColumn('appointments', 'report_approved_by')) {
                $table->foreignId('report_approved_by')->nullable()->constrained('users')->onDelete('set null')->after('report_approved_at');
            }
            if (!Schema::hasColumn('appointments', 'admin_feedback')) {
                $table->text('admin_feedback')->nullable()->after('report_approved_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['report_submitted_by']);
            $table->dropForeign(['report_approved_by']);
            $table->dropColumn([
                'report_status',
                'report_submitted_at',
                'report_submitted_by',
                'report_approved_at',
                'report_approved_by',
                'admin_feedback',
            ]);
        });
    }
};
