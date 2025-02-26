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
        Schema::create('lancamentos_contabeis', function (Blueprint $table) {
            $table->id();
            $table->string('empresa')->nullable();
            $table->date('data')->nullable();
            $table->decimal('valor', 20,2)->nullable();
            $table->string('conta_debito')->nullable();
            $table->string('conta_credito')->nullable();
            $table->string('historico', 2000)->nullable();
            $table->foreignId('id_tiny')->constrained('contas', 'id_tiny')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lancamentos_contabeis');
    }
};
