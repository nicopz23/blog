<?php
session_start();
require "conexion.php";
use Lenovo\Blog\Models\Comment;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["iduser"])) {
        $_SESSION["inicia"];
        header("Location: login");
        exit();
    }

    $iduser = $_SESSION["iduser"];
    $idpost = $_POST["idpost"];
    $body = $_POST["body"];

    // Crear una nueva instancia del modelo Comentario
    $comentario = new Comment();
    $comentario->body = $body;
    $comentario->iduser = $iduser;
    $comentario->idpost = $idpost;

    // Guardar el comentario en la base de datos
    $comentario->save();

    // Redirigir de vuelta a la página de comentarios o al post
    header("Location: comentarios.php?idpost=$idpost&iduser=$iduser");
    exit();
}

