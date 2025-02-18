<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContasPagarModel extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'contas_pagar';

    protected $fillable = [
        'empresa',
        'id_tiny',
        'nome_cliente',
        'historico',
        'numero_doc',
        'data_vencimento',
        'data_emissao',
        'valor',
        'saldo',
        'situacao',
    ];

}
