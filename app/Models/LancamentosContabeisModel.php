<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LancamentosContabeisModel extends Model
{
    
protected $primaryKey = 'id';

    protected $table = 'lancamentos_contabeis';

    protected $fillable = [
        'data',
        'valor',
        'conta_debito',
        'conta_credito',
        'historico',
        'id_tiny',
    ];

    

}
