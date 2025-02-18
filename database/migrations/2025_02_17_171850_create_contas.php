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
        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->string('empresa')->nullable();
            $table->string('data')->nullable();
            $table->string('categoria')->nullable();
            $table->string('historico', 4000)->nullable();
            $table->string('tipo')->nullable();
            $table->string('valor')->nullable();
            $table->string('id_tiny')->nullable();
            $table->string('contato')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('marcadores', 1000)->nullable();
            $table->string('conta')->nullable();
            $table->string('nro_documento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas');
    }
};
