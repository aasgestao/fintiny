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
        Schema::create('plano_contas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clienteempresa', 'cnpj')->onDelete('cascade');
            $table->string('cnpj')->nullable();
            $table->string('conta')->nullable();
            $table->string('analitica')->nullable();
            $table->string('conta_resumida')->nullable();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_contas');
    }
};
