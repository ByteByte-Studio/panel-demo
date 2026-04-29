<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User for Filament
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin'),
            ]
        );

        $this->call([
            UserSeeder::class,
            GroupSeeder::class,
            ClientSeeder::class,
            ProductSeeder::class,
            StageSeeder::class,
            ConversationSeeder::class,
            InternalCommunicationSeeder::class,
        ]);
    }
}
