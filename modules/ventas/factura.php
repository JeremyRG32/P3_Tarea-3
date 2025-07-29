<?php
include('../../library/auth.php');
include("../../library/layout.php");
plantilla::aplicar();

if (!isset($_GET)) {
    echo "No se pudo encontrar la venta";
    exit();
}

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
?>

<body style="background-color: #d9d9d9;">

    <div class="centered-add">
        <div id="factura" style="background-color: #ffffffff; border-radius: 10px;" class="d-flex flex-column justify-content-between p-4">

            <div class="text-center">
                <h1 style="color: #004aad;" class="mt-1">La Rubia</h1>
                <p class="fs-3" style="color: #5c5c5cc0;">Recibo de Venta</p>
            </div>

            <hr class="thick-line">

            <div style="border-radius: 6px; background-color: #73737331;">
                <p class="fs-4 m-1"><strong>Nombre:</strong><span class="fw-normal"> <?= $venta["nombre_cliente"] ?> </span></p>
            </div>

            <div class="text-center mt-2 d-flex justify-content-between">
                <p class="fs-5"><strong>Fecha: </strong><span class="fw-normal"><?= date("d/m/Y", strtotime($venta["fecha"])) ?></span></p>
                <p class="fs-5"><strong>N°Recibo: </strong><span class="fw-normal"><?= "Rec-12" ?></span></p>
            </div>

            <table class="table-borderless table table-bg-blue text-center">
                <thead class="thead-bg-blue">
                    <th>Articulo</th>
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
            <h4 class="text-end fs-4"><strong>Total: RD$<?= number_format($venta['total'], 2) ?></strong></h4>
            <h3>Comentario</h3>
            <textarea readonly class="form-control mb-3"><?= $venta["comentario"] ?></textarea>


            <div class="d-flex justify-content-between gap-5">
                <button id="button1" onclick="generarPDF()" class="btn btn-green">Guardar</button>
                <a id="button2" href="lista.php" class="btn btn-red">Cancelar</a>
            </div>
            <hr class="thick-line">
        </div>

    </div>

</body>

<script>
    function generarPDF() {
        document.getElementById("button1").style.display = "none";
        document.getElementById("button2").style.display = "none";
        const element = document.getElementById("factura");

        setTimeout(() => {
            const options = {
                margin: 0.5,
                filename: 'factura_<?= $venta["id"] ?>.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(options).from(element).save().then(() => {
                window.location.href = "lista.php";
            });

        }, 25);
    }
</script>