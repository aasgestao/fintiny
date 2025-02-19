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
        Schema::create('details_contas_pagar', function (Blueprint $table) {
            $table->id();
            $table->string('data')->nullable();
            $table->string('vencimento')->nullable();
            $table->string('valor')->nullable();
            $table->string('nro_documento')->nullable();
            $table->string('competencia')->nullable();
            $table->string('codigo')->nullable();
            $table->string('nome')->nullable();
            $table->string('tipo_pessoa')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('ie')->nullable();
            $table->string('rg')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('pais')->nullable();
            $table->string('fone')->nullable();
            $table->string('email')->nullable();
            $table->string('historico')->nullable();
            $table->string('categoria')->nullable();
            $table->string('situacao')->nullable();
            $table->string('ocorrencia')->nullable();
            $table->string('dia_vencimento')->nullable();
            $table->string('saldo')->nullable();
            $table->foreignId('id_tiny')->constrained('contas_pagar', 'id_tiny')->onDelete('cascade');
            // $table->foreignId('id_tiny')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_contas_pagar');
    }
};
