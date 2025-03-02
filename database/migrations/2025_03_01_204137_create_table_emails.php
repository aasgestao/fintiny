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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('de');
            $table->string('para');
            $table->string('copia')->nullable();
            $table->string('assunto');
            $table->string('label')->nullable();
            $table->string('marcadores')->nullable();
            $table->string('corpo_email', 4000);
            $table->string('status')->nullable();
            $table->foreignId('cliente_id')->constrained('clienteempresa', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
