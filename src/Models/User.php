<?php

namespace Lenovo\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Nombre de la tabla
    protected $table = 'users';

    // Nombre de la clave primaria
    protected $primaryKey = 'idusers';

    // Si la clave primaria es auto-incremental
    public $incrementing = true;

    public $timestamps = false; // Desactiva las marcas de tiempo

    // Columnas asignables en masa
    protected $fillable = ['nombre', 'email', 'password', 'imagen'];


    //Usuario tiene muchos post
    public function posts()
    {
        return $this->hasMany(Post::class, 'iduser', 'idusers');
    }
}
