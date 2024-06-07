<?php
session_start();
include "conexion.php";

use Lenovo\Blog\Models\Category;
use Lenovo\Blog\Models\Post;

$idpost = $_POST['idpost'];
$post = Post::find($idpost);

if (!$post) {
    $error =  "No se encontró el post";
    $_SESSION["nofind"] = $error;
    header('Location: editpost.php?idpost=' . $idpost);
    exit;
}

$title = $_POST['title'];
$body = $_POST['body'];
$image = $post->image; // Mantener la imagen actual por defecto

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "path/to/images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Comprobar si es una imagen real
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Mover la imagen al directorio de destino
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);
        } else {
            $imagen =  "Error al subir la imagen.";
            $_SESSION["imagen"] = $imagen;
            header('Location: editpost.php?idpost=' . $idpost);
            exit;
        }
    } else {
        $imagen =  "El archivo no es una imagen.";
        $_SESSION["imagen"] = $imagen;
        header('Location: editpost.php?idpost=' . $idpost);
        exit;
    }
}
// Aquí se agregan las categorías
$categoriesInput = $_POST['categories'];
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
    $post->categories()->attach($category->id);
}

$post->title = $title;
$post->body = $body;
$post->image = $image;

$post->save();

header('Location: editpost?idpost=' . $idpost);
exit;
