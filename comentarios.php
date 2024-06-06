<?php
session_start();
include 'conexion.php';
use Lenovo\Blog\Models\Comment;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_SESSION["iduser"])) {
        $_SESSION["inicia"] = 0;
        header("Location: login");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
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
            padding: 20px;
            border-radius: 10px;
        }

        .comentarios-container {
            margin-top: 30px;
        }

        .comentario {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .comentario p {
            margin-bottom: 5px;
        }

        .comentario-textarea {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <h1 class="text-center">Comentarios</h1>

        <!-- Mostrar comentarios -->
        <div class="comentarios-container">
            <?php
            $idpost = $_GET['idpost'];
            $comentarios = Comment::where('idpost', $idpost)->get();

            // Mostrar los comentarios
            foreach ($comentarios as $comentario) {
                echo '<div class="comentario">';
                echo '<p>' . $comentario->body . '</p>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Agregar comentario -->
        <h2 class="mt-5">Agregar Comentario</h2>
        <form action="guardar_comentario" method="POST" class="comentario-textarea">
            <input type="hidden" name="idpost" value="<?php echo $_GET['idpost']; ?>">
            <textarea name="body" rows="4" class="form-control" required></textarea>
            <button type="submit" class="btn btn-primary mt-3">Enviar Comentario</button>
        </form>
    </div>

    <!-- Bootstrap JS (opcional, si necesitas funcionalidad de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>