<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteEmpresaModel extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'clienteempresa';

    protected $fillable = ['nome', 'token_tiny', 'cnpj'];
}
