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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("full_name")->index();
            $table->string("person_type")->nullable();
            $table->string("client_type");
            $table->string("phone_number");
            $table->string("email")->nullable();
            $table->string("curp")->nullable(); //Las empresas no tienen CURP
            $table->string("rfc")->nullable();
            $table->string("address")->nullable();
            $table->string("ine_id")->nullable();
            $table->string("occupation")->nullable();
            $table->dateTime("date_of_birth")->nullable(); //Las empresas no tienen fecha de nacimiento
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
