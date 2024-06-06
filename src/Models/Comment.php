<?php

namespace Lenovo\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Nombre de la tabla
    protected $table = 'coments';

    // Nombre de la clave primaria
    protected $primaryKey = 'idcoments';

    // Si la clave primaria es auto-incremental
    public $incrementing = true;

    public $timestamps = false; // Desactiva las marcas de tiempo


    // Columnas asignables en masa
    protected $fillable = ['body', 'create_date', 'iduser', 'idpost'];
}
