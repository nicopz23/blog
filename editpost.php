<?php
session_start();
include "conexion.php";

use Lenovo\Blog\Models\Post;

$idpost = $_GET["idpost"];
$post = Post::where('idposts', $idpost)->first();

$imagenerror = isset($_SESSION["imagen"]) ? $_SESSION["imagen"] : null;
$nofinderror = isset($_SESSION["nofind"]) ? $_SESSION["nofind"] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Post</title>
    <!-- Enlace a Bootstrap desde una CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        .container {
            background-color: white;
            margin-top: 50px;
            padding: 20px;
            border-radius: 10px;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: #fff;
        }

        .form-group img {
            margin-top: 10px;
        }
    </style>
</head>

<body>

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
        <h1>Editar Post</h1>

        <?php if ($imagenerror) : ?>
            <div class="alert alert-danger">
                <?php echo $imagenerror;
                unset($_SESSION["imagen"]); ?>
            </div>
        <?php endif; ?>

        <?php if ($nofinderror) : ?>
            <div class="alert alert-danger">
                <?php echo $nofinderror;
                unset($_SESSION["nofind"]); ?>
            </div>
        <?php endif; ?>

        <?php if (is_null($imagenerror) && is_null($nofinderror) && $post) : ?>
            <form action="updatepost.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idpost" value="<?php echo $post->idposts; ?>">
                <div class="mb-3">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post->tittle); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="body">Contenido:</label>
                    <textarea class="form-control" id="body" name="body" required><?php echo htmlspecialchars($post->body); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Imagen:</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <br>
                    <p>Imagen actual:</p>
                    <br>
                    <img src="src/imagenes_posts/<?php echo $post->imagen; ?>" alt="Current Image" width="150">
                </div>
                <div class="mb-3">
                    <label for="categories" class="form-label">Categorías (separadas por comas)</label>
                    <input type="text" class="form-control" id="categories" name="categories">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="borrarpost?idpost=<?php echo $idpost ?>"><button type="button" class="btn btn-danger">Borrar Post</button></a>
                </div>
            </form>
        <?php else : ?>
            <div class="alert alert-danger">
                No se encontró el post.
            </div>
        <?php endif; ?>
    </div>
    <!-- Enlace a jQuery y Bootstrap desde una CDN -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>