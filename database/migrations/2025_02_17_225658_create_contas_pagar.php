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
        Schema::create('contas_pagar', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->string('id_tiny')->nullable();
            $table->string('nome_cliente')->nullable();
            $table->string('historico', 4000)->nullable();
            $table->string('numero_doc')->nullable();
            $table->string('data_vencimento')->nullable();
            $table->string('data_emissao')->nullable();
            $table->string('valor')->nullable();
            $table->string('saldo')->nullable();
            $table->string('situacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas_pagar');
    }
};
