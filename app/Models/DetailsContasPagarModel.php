<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailsContasPagarModel extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'details_contas_pagar';

    protected $fillable = [
        'id_tiny',
        'data',
        'vencimento',
        'valor',
        'nro_documento',
        'competencia',
        'codigo',
        'nome',
        'tipo_pessoa',
        'cpf_cnpj',
        'ie',
        'rg',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'uf',
        'pais',
        'fone',
        'email',
        'historico',
        'categoria',
        'situacao',
        'ocorrencia',
        'dia_vencimento',
        'saldo',
    ];

}
