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
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('copyright_text')->nullable();
            $table->timestamps();
        });

        // Insert default data
        DB::table('footer_settings')->insert([
            'description' => 'Developed with dermatologists, our skincare products help restore and maintain your skin\'s natural protective barrier.',
            'facebook_url' => '#',
            'instagram_url' => '#',
            'tiktok_url' => '#',
            'youtube_url' => '#',
            'address' => 'Level 13, Menara Lien Hoe, Petaling Jaya, 47301 Malaysia',
            'phone' => '+60 3-7491 0000',
            'email' => 'contact@ceravemy.com',
            'copyright_text' => '© 2025 CeraVe Malaysia. All rights reserved.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
