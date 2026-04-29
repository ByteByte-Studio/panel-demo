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
        Schema::table('payments', function (Blueprint $table) {
            $table->date('due_date')->after('amount')->nullable();
            $table->boolean('is_notification_enabled')->default(true);
            $table->timestamp('last_reminded_at')->nullable();

            $table->string('payment_status')->default('pending');
            // pagado, pendiente, pago_parcial, cancelado

            $table->string('notification_status')->default('not_reminded');
            // not_reminded, early_reminder, reminder, late_reminder, disabled

            $table->renameColumn('payment_metod', 'payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('due_date');
            $table->dropColumn('is_notification_enabled');
            $table->dropColumn('last_reminded_at');
            $table->dropColumn('payment_status');
            $table->dropColumn('notification_status');
            $table->renameColumn('payment_method', 'payment_metod');
        });
    }
};
