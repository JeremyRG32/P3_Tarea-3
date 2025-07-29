<?php
include('../../library/auth.php');
include("../../library/layout.php");
plantilla::aplicar();

$sql = "SELECT * FROM ventas";
$ventas = $conn->query($sql);

if (!$ventas) {
    die("Query invalido: " . $conn->error);
}

if (isset($_SESSION['mensaje'])) {
    echo '<div class="alert alert-' . $_SESSION['tipo_mensaje'] . ' alert-dismissible fade show">'
        . $_SESSION['mensaje'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';

    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo_mensaje']);
}

?>

<body style="background-color: whitesmoke;">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Ventas</h1>
            <a href="agregar.php" class="btn btn-primary">Registrar Venta</a>
        </div>

        <div class="row g-3 text-center">
            <?php
            foreach ($ventas as $v) { ?>
                <div>
                    <table class="table table-striped shadow-sm">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Fecha y hora</th>
                                <th>Comentario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td><?=$v['nombre_cliente']?></td>
                            <td>RD$<?=$v['total']?></td>
                            <td><?=$v['fecha']?></td>
                            <td><?=$v['comentario']?></td>
                            <td>
                                <a href="detalles.php?id=<?=$v['id']?>" class="btn btn-primary">Detalles</a>
                                <a href="eliminar.php?id=<?=$v['id']?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tbody>
                    </table>
                </div>
            <?php }
            ?>
        </div>
    </div>

</body>