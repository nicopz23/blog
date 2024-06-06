<?php
session_start();
require "conexion.php";

// Obtener todos los posts
use Lenovo\Blog\Models\Post;
use Lenovo\Blog\Models\Category;

if (isset($_SESSION["iduser"])) {
    $iduser = $_SESSION["iduser"];
    $posts = Post::where('iduser', $iduser)->orderBy('create_date', 'desc')->get();
    $categorias = Category::where('iduser', $iduser)->distinct()->get(['name']);
} else {
    $posts = Post::orderBy('create_date', 'desc')->get();
    $categorias = Category::distinct()->get(['name']);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        .container {
            background-color: white;
            margin-top: 50px;
        }

        .post-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .post {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
            max-width: 350px;
        }

        .post-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: #007bff;
        }

        .post-image {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .post-body {
            font-size: 16px;
            color: #6c757d;
        }

        .post-date {
            font-size: 14px;
            color: #6c757d;
        }

        .categorias {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 10px;
            margin-left: auto;
            /* Alinea a la derecha */
            width: auto;
            /* Se ajusta al contenido */
        }

        .categorias ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .categorias ul li {
            margin-bottom: 5px;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="contacto">Contacto</a>
                    </li>
                    <?php if (isset($_SESSION["iduser"])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="newpost">Crear Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout">Cerrar Sesión</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login">Acceder</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
    <h1 class="text-center mb-5">Blog</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Aquí van los posts -->
            <?php foreach ($posts as $post) : ?>
                <div class="post-container">
                    <div class="post">
                    <h2><a href="comentarios?idpost=<?php echo $post->idposts; ?>&iduser=<?php if(isset($_SESSION["iduser"])){ echo $iduser; }?>"><?php echo $post->tittle; ?></a></h2>
                        <img class="post-image" src="src/imagenes_posts/<?php echo $post->imagen; ?>" alt="Imagen del post">
                        <p class="post-body"><?php echo $post->body; ?></p>
                        <p class="post-date">Publicado en <?php echo $post->create_date; ?></p>
                        <p class="post-categories">
                            Categorías: 
                            <?php if (!is_null($post->categorias) or $post->categorias= "") : ?>
                                <?php foreach ($post->categorias as $index => $category) : ?>
                                    <?php echo $category->name; ?>
                                    <?php if ($index < count($post->categorias) - 1) : ?>
                                        ,
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <span>Sin categorías</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <!-- Aquí van las categorías -->
            <div class="categorias">
                <h2>Categorías</h2>
                <ul>
                    <?php foreach ($categorias as $categoria) : ?>
                        <li><?php echo $categoria->name; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS (opcional, si necesitas funcionalidad de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>