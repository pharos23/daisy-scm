<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Create the contacts table
return new class extends Migration
{
    /**
     * Run the migrations.
     * With all the variables we want to create for the Contacts table.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('local');
            $table->string('grupo');
            $table->string('nome');
            $table->string('telemovel');
            $table->string('extensao')->nullable();
            $table->string('funcionalidades')->nullable();
            $table->string('ativacao')->nullable();
            $table->string('desativacao')->nullable();
            $table->string('ticket_scmp')->nullable();
            $table->string('ticket_fse')->nullable();
            $table->string('iccid')->nullable();
            $table->string('equipamento')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('imei')->nullable();
            $table->text('obs')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
