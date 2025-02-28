<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BancosModel extends Model
{
    /*nome
codigo_tiny
cliente_id*/

     protected $primaryKey = 'id';

    protected $table = 'bancos';

    protected $fillable = ['nome', 'conta_tiny', 'cliente_id', 'plano_conta'];
}
