<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'solution')) {
                $table->text('solution')->nullable()->after('concerns');
            }
            if (!Schema::hasColumn('appointments', 'ai_suggestion')) {
                $table->text('ai_suggestion')->nullable()->after('solution');
            }
            if (!Schema::hasColumn('appointments', 'consultant_notes')) {
                $table->text('consultant_notes')->nullable()->after('ai_suggestion');
            }
            if (!Schema::hasColumn('appointments', 'suggested_products')) {
                $table->text('suggested_products')->nullable()->after('consultant_notes');
            }
            if (!Schema::hasColumn('appointments', 'usage_instructions')) {
                $table->text('usage_instructions')->nullable()->after('suggested_products');
            }
            if (!Schema::hasColumn('appointments', 'purchased_products')) {
                $table->text('purchased_products')->nullable()->after('usage_instructions');
            }
            if (!Schema::hasColumn('appointments', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'solution',
                'ai_suggestion',
                'consultant_notes',
                'suggested_products',
                'usage_instructions',
                'purchased_products',
                'completed_at',
            ]);
        });
    }
};
