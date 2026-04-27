<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conversation::factory()
            ->count(20)
            ->create()
            ->each(function (Conversation $conversation) {
                Message::factory()->count(10)->create([
                    'conversation_id' => $conversation->id,
                ]);
            });
    }
}
