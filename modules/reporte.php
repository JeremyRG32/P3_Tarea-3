<?php
include('../library/auth.php');
include("../library/layout.php");
plantilla::aplicar();
$fecha_filtro = $_GET['fecha'] ?? date('Y-m-d');

$ventasdia = $conn->query("SELECT ventas.id, ventas.nombre_cliente, ventas.fecha, ventas.total
FROM ventas
WHERE DATE(ventas.fecha) = '$fecha_filtro'
ORDER BY ventas.fecha DESC;");

$totaldia = $conn->query("SELECT SUM(detalles_venta.cantidad * detalles_venta.precio_unitario) As total
FROM detalles_venta Join ventas on detalles_venta.venta_id = ventas.id 
WHERE DATE(ventas.fecha) = '$fecha_filtro'");

$totaldia = $totaldia->fetch_assoc();

if(empty($totaldia == null)){
    $totaldia['total'] = 0;
}


?>

<body style="background-color: #f8f9fa;">
    <div style="background-color: rgba(161, 161, 161, 0.2); border-radius: 6px; min-height: 700px;" class="d-flex flex-column container p-4">

        <h1 class="text-center mb-4">Reporte de Ventas Diarias</h1>

        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <form method="get" class="d-flex">
                    <input type="date" name="fecha" value="<?= $fecha_filtro ?>" class="form-control me-2">
                    <button type="submit" style="width: 100px;" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
        </div>

        <p class="text-center fs-3">Ventas de: <?= $fecha_filtro ?></p>

        <table class="table table-bordered">
            <thead>
                <th>Cliente</th>
                <th>Fecha y Hora</th>
                <th>Total</th>
                <th>Acciones</th>
            </thead>
            <?php
            ?>
            <tbody>
                <?php
                while ($fila = $ventasdia->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $fila['nombre_cliente'] ?></td>
                        <td><?= $fila['fecha'] ?></td>
                        <td><?= "RD$" . number_format($fila['total'], 2) ?></td>
                        <td class="text-center"><a href="ventas/detalles.php?id=<?=$fila['id']?>" class="btn btn-primary">Detalles</a></td>
                    </tr>
                <?php }
                ?>
            </tbody>
            <tfoot class="table-active">
                <tr class="d-flex">
                    <th class="fs-3">Total del día:</th>
                    <th class="fs-3">
                        <p>RD$<?=number_format($totaldia['total'], 2) ?></p>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>