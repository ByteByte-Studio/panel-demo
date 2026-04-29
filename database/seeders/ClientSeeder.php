<?php

namespace Database\Seeders;

use App\Models\Appointments;
use App\Models\Client;
use App\Models\Document;
use App\Models\Group;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Group::all();

        if ($groups->isEmpty()) {
            $groups = Group::factory()->count(5)->create();
        }

        Client::factory()
            ->count(50)
            ->create()
            ->each(function (Client $client) use ($groups) {
                // Assign to a random group
                $client->update(['group_id' => $groups->random()->id]);

                // Create 1-3 payments
                Payment::factory()->count(rand(1, 3))->create([
                    'client_id' => $client->id,
                    'paymentable_id' => $client->id,
                    'paymentable_type' => Client::class,
                ]);

                // Create 1-2 appointments
                Appointments::factory()->count(rand(1, 2))->create([
                    'appointmentable_id' => $client->id,
                    'appointmentable_type' => Client::class,
                ]);

                // Create 2-4 documents
                Document::factory()->count(rand(2, 4))->create([
                    'documentable_id' => $client->id,
                    'documentable_type' => Client::class,
                ]);
            });
    }
}
