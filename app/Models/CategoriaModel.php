<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'categorias';

    protected $fillable = [
        'empresa',
        'nome', 
        'plano_contas',
        'cliente_id',
    ];
}
