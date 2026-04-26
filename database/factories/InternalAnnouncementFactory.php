<?php

namespace Database\Factories;

use App\Models\InternalAnnouncement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternalAnnouncementFactory extends Factory
{
    protected $model = InternalAnnouncement::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'body' => $this->faker->paragraph(4),
            'created_by' => User::factory(),
        ];
    }
}
