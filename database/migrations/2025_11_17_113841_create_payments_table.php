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
        //convertir en morph para que se pueda asociar con cliente y con caso
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("client_id")->index();
            $table->double("amount");
            $table->string("payment_metod");
            $table->string("concept");
            $table->string("transaction_reference")->nullable();
            $table->morphs("paymentable");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
