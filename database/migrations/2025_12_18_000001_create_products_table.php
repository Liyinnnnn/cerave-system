<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // If the table already exists (earlier migration), add missing columns instead of recreating.
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('products', 'category')) {
                    $table->string('category')->nullable()->after('name');
                }
                if (!Schema::hasColumn('products', 'description')) {
                    $table->text('description')->nullable()->after('category');
                }
                if (!Schema::hasColumn('products', 'ingredients')) {
                    $table->text('ingredients')->nullable()->after('description');
                }
                if (!Schema::hasColumn('products', 'benefits')) {
                    $table->text('benefits')->nullable()->after('ingredients');
                }
                if (!Schema::hasColumn('products', 'directions')) {
                    $table->text('directions')->nullable()->after('benefits');
                }
                if (!Schema::hasColumn('products', 'skin_type')) {
                    $table->enum('skin_type', ['dry', 'oily', 'combination', 'sensitive', 'normal'])->nullable()->after('directions');
                }
                if (!Schema::hasColumn('products', 'price')) {
                    $table->decimal('price', 8, 2)->default(0)->after('skin_type');
                }
                if (!Schema::hasColumn('products', 'rating')) {
                    $table->float('rating')->default(0)->after('price');
                }
                if (!Schema::hasColumn('products', 'image_url')) {
                    $table->string('image_url')->nullable()->after('rating');
                }
                if (!Schema::hasColumn('products', 'external_url')) {
                    $table->string('external_url')->nullable()->after('image_url');
                }
            });
            return;
        }

        // Fresh installs create the table with the full schema.
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('category')->index();
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('benefits')->nullable();
            $table->text('directions')->nullable();
            $table->enum('skin_type', ['dry', 'oily', 'combination', 'sensitive', 'normal'])->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->float('rating')->default(0);
            $table->string('image_url')->nullable();
            $table->string('external_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            foreach (['external_url', 'image_url', 'rating', 'price', 'skin_type', 'directions', 'benefits', 'ingredients', 'description', 'category', 'name'] as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
