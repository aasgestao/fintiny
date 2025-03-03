<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArquivosModel extends Model
{
    protected $primaryKey = 'id';
    
    protected $table = 'arquivos';

    protected $fillable = ['path', 'empresa', 'email_id', 'importacao_id'];
}

