<?php

namespace Lenovo\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Nombre de la tabla
    protected $table = 'posts';

    // Nombre de la clave primaria
    protected $primaryKey = 'idposts';

    // Si la clave primaria es auto-incremental
    public $incrementing = true;

    public $timestamps = false; // Desactiva las marcas de tiempo


    // Columnas asignables en masa
    protected $fillable = ['tittle', 'body', 'imagen', 'create_date', 'iduser'];

    //Post tiene muchos comentarios
    public function comments()
    {
        return $this->hasMany(Comment::class, 'idpost', 'idposts');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
