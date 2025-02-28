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
        Schema::create('bancos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('conta_tiny');
            $table->string('plano_conta');
            $table->foreignId('cliente_id')->constrained('clienteempresa', 'id')->onDelete('cascade');
            //$table->foreign('cliente_id')->references('id')->on('clienteempresa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancos');
    }
};
