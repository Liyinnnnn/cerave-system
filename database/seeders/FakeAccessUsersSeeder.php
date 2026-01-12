<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FakeAccessUsersSeeder extends Seeder
{
    /**
     * Seed the application's database with immediate-access admin and consultant.
     */
    public function run(): void
    {
        $records = [
            [
                'name' => 'Admin User',
                'email' => 'admin@cerave.my',
                'password' => 'admin123',
                'role' => 'admin',
            ],
            [
                'name' => 'Consultant User',
                'email' => 'consultant@cerave.my',
                'password' => 'consultant123',
                'role' => 'consultant',
            ],
        ];

        foreach ($records as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'role' => $data['role'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
