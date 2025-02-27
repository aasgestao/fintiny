<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanoContasModel extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'plano_contas';

    protected $fillable = [
        'cliente_id',
        'cnpj',
        'conta',
        'analitica',
        'conta_resumida',
        'descricao',
    ];

}
