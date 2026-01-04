<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        // Ensure OAuth-created users have a non-null random password to satisfy DB constraints.
        $placeholder = Hash::make(Str::random(32));

        DB::table('users')
            ->whereNotNull('email_verified_at')
            ->where('role', 'consumer') // Only consumer accounts auto-verified
            ->whereNull('password')
            ->update(['password' => $placeholder]);
    }

    public function down(): void
    {
        // Cannot safely restore old passwords, so skip rollback
    }
};
