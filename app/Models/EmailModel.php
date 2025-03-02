<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailModel extends Model
{
    
    protected $primaryKey = 'id';

    protected $table = 'emails';

    protected $fillable = [
        'de',
        'para',
        'copia',
        'assunto',
        'label',
        'marcadores',
        'corpo_email',
        'cliente_id',
    ];
}
