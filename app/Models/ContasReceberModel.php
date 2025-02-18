<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContasReceberModel extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'contas_receber';

    protected $fillable = [
        'empresa',
        'id_tiny',
        'nome_cliente',
        'historico',
        'numero_banco',
        'numero_doc',
        'serie_doc',
        'data_vencimento',
        'data_emissao',
        'valor',
        'saldo',
        'situacao',
    ];
}
