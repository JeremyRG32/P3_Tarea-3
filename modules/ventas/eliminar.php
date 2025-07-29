<?php
include('../../library/auth.php');
include("../../library/layout.php");
plantilla::aplicar();

if($_GET){

    $id = $_GET['id'];

    $sqlventa = "SELECT * FROM ventas WHERE id = $id";
    $venta = $conn->query($sqlventa);

    if (!$venta || $venta->num_rows == 0) {
        echo "Venta no encontrada.";
        exit();
    }

    $venta = $venta->fetch_assoc();

    $sqldetalles = "SELECT detalles_venta.*, productos.nombre AS nombre_producto
                FROM detalles_venta JOIN productos ON detalles_venta.producto_id = productos.id
                WHERE detalles_venta.venta_id = $id";

    $detalles = $conn->query($sqldetalles);
}


if ($_POST) {
    $id = $_POST['id'];
    $sqldeletedetalle = "DELETE FROM detalles_venta WHERE venta_id = $id";
    $sqldeleteventa = "DELETE FROM ventas WHERE id = $id";

    $resultdetalle = $conn->query($sqldeletedetalle);
    $resultventa = $conn->query($sqldeleteventa);

    if ($resultdetalle && $resultventa) {
        $_SESSION['tipo_mensaje'] = "success";
        $_SESSION['mensaje'] = "Venta Eliminada Correctamente";
        header("Location: lista.php");
    }
}



?>

<body style="background-color: #f8f9fa;">

    <div style="background-color: rgba(161, 161, 161, 0.2); border-radius: 6px; min-height: 700px;" class=" d-flex flex-column justify-content-between container p-4">

        <h1 class="mt-1 text-center">Eliminar la venta</h1>

        <div class="text-center mb-5 d-flex justify-content-between">
            <h3 class="">Cliente: <span class="fw-normal"> <?= $venta["nombre_cliente"] ?> </span></h3>
            <h3 class="">Fecha y hora: <span class="fw-normal"><?= $venta["fecha"] ?></span></h3>
        </div>


        <h3 class="text-center">Productos</h3>
        <table class="table table-bordered">
            <thead>
                <th>Artículo</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </thead>
            <?php
            ?>
            <tbody>
                <?php
                while ($fila = $detalles->fetch_assoc()) {
                    $subtotal = $fila['cantidad'] * $fila['precio_unitario'];
                ?>
                    <tr>
                        <td><?= $fila['nombre_producto'] ?></td>
                        <td><?= $fila['cantidad'] ?></td>
                        <td><?= "RD$" . number_format($fila['precio_unitario'], 2) ?></td>
                        <td><?= "RD$" . number_format($subtotal, 2) ?></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <h4 class="text-end">Total de la venta: RD$<?= number_format($venta['total'], 2) ?> </h4>
        <h3>Comentario</h3>
        <textarea readonly class="form-control mb-3"><?= $venta["comentario"] ?></textarea>

        <div class="d-flex justify-content-between gap-5">
            <form action="eliminar.php" method="post">
                <button style="width: 600px;" class="btn btn-danger flex-fill">Eliminar</button>
                <input hidden name="id" value="<?= $venta['id'] ?>">
            </form>
            <a href="lista.php" class="btn btn-secondary flex-fill">Volver</a>
        </div>
    </div>
</body>