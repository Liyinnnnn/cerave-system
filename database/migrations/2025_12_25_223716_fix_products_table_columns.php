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
        Schema::table('products', function (Blueprint $table) {
            // Drop old unused columns if they exist
            if (Schema::hasColumn('products', 'productName')) {
                $table->dropColumn('productName');
            }
            if (Schema::hasColumn('products', 'skinType')) {
                $table->dropColumn('skinType');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Restore old columns if rolling back
            if (!Schema::hasColumn('products', 'productName')) {
                $table->string('productName')->nullable();
            }
            if (!Schema::hasColumn('products', 'skinType')) {
                $table->string('skinType')->nullable();
            }
        });
    }
};
