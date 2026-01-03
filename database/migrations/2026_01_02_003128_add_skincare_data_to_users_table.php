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
        Schema::table('users', function (Blueprint $table) {
            $table->string('skin_type')->nullable()->after('email');
            $table->text('skin_concerns')->nullable()->after('skin_type');
            $table->text('skin_conditions')->nullable()->after('skin_concerns');
            $table->json('using_products')->nullable()->after('skin_conditions'); // Products user is currently using
            $table->timestamp('skincare_profile_updated_at')->nullable()->after('using_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'skin_type',
                'skin_concerns',
                'skin_conditions',
                'using_products',
                'skincare_profile_updated_at'
            ]);
        });
    }
};
