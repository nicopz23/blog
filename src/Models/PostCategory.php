<?php

namespace Lenovo\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    // Nombre de la tabla
    protected $table = 'posts_categorys';

    // No hay clave primaria auto-incremental
    public $incrementing = false;

    public $timestamps = false; // Desactiva las marcas de tiempo


    // Clave primaria compuesta
    protected $primaryKey = ['idpost', 'idcategory'];

    // Columnas asignables en masa
    protected $fillable = ['idpost', 'idcategory'];

    // Indicar a Eloquent que la clave primaria no es una sola columna
    public $primaryKeyType = 'array';
    
    // Método para manejar la clave primaria compuesta
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('idpost', '=', $this->getAttribute('idpost'))
            ->where('idcategory', '=', $this->getAttribute('idcategory'));
        return $query;
    }
}
