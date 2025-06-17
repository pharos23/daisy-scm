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
            $table->boolean('serial_number')->default(false);
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
