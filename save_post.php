<?php
session_start();
if (!isset($_SESSION["iduser"])) {
    header("Location: login");
    exit();
}

require "conexion.php";
use Lenovo\Blog\Models\Post;

$iduser = $_SESSION["iduser"];
$title = $_POST['title'];
$body = $_POST['body'];
$image = $_FILES['image'];

// Manejo del archivo de imagen
$target_dir = "src/imagenes_posts/";
$target_file = $target_dir . basename($image["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar si el archivo es una imagen real
$check = getimagesize($image["tmp_name"]);
if ($check === false) {
    echo "El archivo no es una imagen.";
    exit();
}

// Verificar si el archivo ya existe
if (file_exists($target_file)) {
    echo "Lo siento, el archivo ya existe.";
    exit();
}

// Limitar el tamaño del archivo
if ($image["size"] > 500000) {
    echo "Lo siento, tu archivo es demasiado grande.";
    exit();
}

// Limitar los formatos de archivo permitidos
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
    exit();
}

// Intentar subir el archivo
if (move_uploaded_file($image["tmp_name"], $target_file)) {
    // Crear el post en la base de datos
    $post = new Post();
    $post->tittle = $title;
    $post->body = $body;
    $post->imagen = basename($image["name"]);
    $post->iduser = $iduser;
    $post->save();

    // Redirigir al index
    header("Location: ./");
    exit();
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}
