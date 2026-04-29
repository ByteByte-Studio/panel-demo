<?php

namespace Database\Seeders;

use App\Models\InternalAnnouncement;
use App\Models\InternalMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class InternalCommunicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            $users = User::factory()->count(5)->create();
        }

        // Create announcements
        InternalAnnouncement::factory()->count(10)->create([
            'created_by' => $users->random()->id,
        ]);

        // Create internal messages
        InternalMessage::factory()->count(30)->create()->each(function (InternalMessage $message) use ($users) {
            $message->update(['sender_id' => $users->random()->id]);

            // Attach recipients (many-to-many)
            $recipients = $users->random(rand(1, 3))->pluck('id');
            $message->recipients()->attach($recipients, [
                'attended_at' => rand(0, 1) ? now() : null,
            ]);
        });
    }
}
