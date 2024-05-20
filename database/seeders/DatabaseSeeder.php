<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('admins')->insert(
            [
                ['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => bcrypt('admin@mail.com'), 'role' => 'admin'],
            ]
        );
        DB::table('admins')->insert(
            [
                ['name' => 'Admin', 'email' => 'nuel@gmail.com', 'password' => bcrypt('admin'), 'role' => 'admin'],
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'User 1', 'email' => 'user1@mail.com', 'password' => bcrypt('user1')
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'User 2', 'email' => 'user2@mail.com', 'password' => bcrypt('user1')
            ]
        );
    }
}
