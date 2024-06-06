<?php

namespace Lenovo\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Nombre de la tabla
    protected $table = 'categorys';

    // Nombre de la clave primaria
    protected $primaryKey = 'id';

    // Si la clave primaria es auto-incremental
    public $incrementing = true;

    public $timestamps = false; // Desactiva las marcas de tiempo


    // Columnas asignables en masa
    protected $fillable = ['name', 'iduser'];
}
