<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->morphs('appointmentable');
            $table->dateTime('date_time');
            $table->text('reason'); // Rason de la cita
            $table->string('status')->default('pending');
            $table->string('modality')->nullable(); // Presencial, virtual, o telefonica
            $table->longText('notes')->nullable();

            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamp('confirmed_by_reminder_at')->nullable();
            $table->timestamp('reschedule_proposed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
