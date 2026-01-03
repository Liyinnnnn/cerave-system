<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Set password to null for users likely created via OAuth
        // (they were auto-verified on creation)
        DB::table('users')
            ->whereNotNull('email_verified_at')
            ->where('role', 'consumer') // Only consumer accounts auto-verified
            ->update(['password' => null]);
    }

    public function down(): void
    {
        // Cannot safely restore old passwords, so skip rollback
    }
};
