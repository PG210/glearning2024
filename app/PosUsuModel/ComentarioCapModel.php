<?php

namespace App\PosUsuModel;

use Illuminate\Database\Eloquent\Model;

class ComentarioCapModel extends Model
{
    protected $table = 'comentariocapitulo';//crea un modelo la cual esta apuntando a la tabla carga users
    protected $primarykey = 'id';
    protected $fillable = ['comentario', 'valor', 'user_id', 'capitulo_id'];
}

