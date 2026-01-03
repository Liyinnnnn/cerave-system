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
            $table->text('skin_assessment')->nullable()->after('consultant_notes');
            $table->json('recommended_products')->nullable()->after('skin_assessment');
            $table->text('skincare_advice')->nullable()->after('recommended_products');
            $table->text('lifestyle_tips')->nullable()->after('skincare_advice');
            $table->timestamp('report_generated_at')->nullable()->after('lifestyle_tips');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['skin_assessment', 'recommended_products', 'skincare_advice', 'lifestyle_tips', 'report_generated_at']);
        });
    }
};
