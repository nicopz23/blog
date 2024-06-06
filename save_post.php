<?php
session_start();
if (!isset($_SESSION["iduser"])) {
    header("Location: login");
    exit();
}

require "conexion.php";

use Lenovo\Blog\Models\Post;
use Lenovo\Blog\Models\Category;


$iduser = $_SESSION["iduser"];
$title = $_POST['title'];
$body = $_POST['body'];
$image = $_FILES['image'];
$categoriesInput = $_POST['categories'];

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

if (move_uploaded_file($image["tmp_name"], $target_file)) {
    // Crear el post en la base de datos
    $post = new Post();
    $post->tittle = $title;
    $post->body = $body;
    $post->imagen = basename($target_file);
    $post->iduser = $iduser;
    $post->save();

    // Asignar categorías al post
    $categories = array_map('trim', explode(',', $categoriesInput));
    foreach ($categories as $categoryName) {
        // Buscar la categoría por su nombre y el ID de usuario
        $category = Category::where('name', $categoryName)
            ->where('iduser', $iduser)
            ->first();

        // Si la categoría no existe, crear una nueva
        if (!$category) {
            $category = new Category();
            $category->name = $categoryName;
            $category->iduser = $iduser;
            $category->save();
        }

        // Adjuntar la categoría al post
        $post->categorias()->attach($category->id);
    }

    // Redirigir al index
    header("Location: ./");
    exit();
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}
