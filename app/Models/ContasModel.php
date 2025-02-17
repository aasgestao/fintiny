<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContasModel extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'contas';

    protected $fillable = [
        'empresa',
        'data',
        'categoria',
        'historico',
        'tipo',
        'valor',
        'id_tiny',
        'contato',
        'cnpj',
        'marcadores',
        'conta',
        'nro_documento',
    ];

}
