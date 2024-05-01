<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\DB;
>>>>>>> ed30d43 (first commit)

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

<<<<<<< HEAD
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
=======
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('admins')->insert(
            [
                ['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => bcrypt('admin'), 'role' => 'admin'],
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'User 1', 'email' => 'user1@mail.com', 'password' => bcrypt('user1')
            ]
        );
>>>>>>> ed30d43 (first commit)
    }
}
