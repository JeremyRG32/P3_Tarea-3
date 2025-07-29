<?php
include("dbconfig.php");
class plantilla
{
    static $instance = null;

    public static function aplicar()
    {
        if (self::$instance == null) {
            self::$instance = new plantilla();
        }
        return self::$instance;
    }

    function __construct()
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sistema de Venta</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo6l4uCk9B0v7MZ8E1Pq23CjwR8W9zDkF1zp7W9ap7K/4xg" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="/library/style.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        </head>


        <header>
            <nav style="background: rgba(87, 107, 255, 1);" class="navbar navbar-expand-lg px-4">
                <a class="navbar-brand text-white fw-bold" href="/modules/inicio.php">La Rubia</a>

                <div class="navbar-collapse justify-content-between">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/modules/ventas/lista.php">Ventas</a>
                        </li>
                        <li>
                            <a class="nav-link text-white" href="/modules/productos/lista.php">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/modules/reporte.php">Reportes</a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center text-white">
                        <span class="me-3">
                            <?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Invitado'; ?>
                        </span>
                        <a href="/logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
                    </div>
                </div>
            </nav>
        </header>
    <?php

    }

    function __destruct()
    {
    ?>

        </html>
<?php
    }
}
?>