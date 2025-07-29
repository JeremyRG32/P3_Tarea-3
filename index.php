<?php
if (!file_exists("library/instalado.lock")) {
    header("Location: /library/install.php");
    exit();
}
include("library/layout.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/library/style.css">

</head>

<body>
    <div class="centered">
        <form class="p-5 m-5 shadow rounded-2 bg-white" method="post" action="login.php">
            <h1 class="text-center">Iniciar Sesión</h1>
            <?php
            if (isset($_GET['error'])) {
            ?>
                <div class="error"> <?= $_GET['error'] ?></div>

            <?php }

            ?>
            <label class="form-label">Usuario</label>
            <input class="form-control" autocomplete="off" name="usuario" placeholder="Usuario">

            <label class="form-label">Contraseña</label>
            <input class="form-control" type="password" name="clave" placeholder="Contraseña">

            <button class="btn btn-primary container mt-3" type="submit">Inciar Sesión</button>

        </form>
    </div>
</body>

</html>