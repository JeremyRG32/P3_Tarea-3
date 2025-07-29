<?php
include('../../library/auth.php');
include("../../library/layout.php");
plantilla::aplicar();

$productos = $conn->query("SELECT id, nombre, precio FROM productos");

$productos_options = '';
while ($fila = $productos->fetch_assoc()) {
    $productos_options .= "<option value='{$fila['id']}'>{$fila['nombre']}</option>";
}
if ($_POST) {

    //Procesamos datos e insertamos venta principal sin el total
    $nombre_cliente = $conn->real_escape_string($_POST['nombre_cliente']);
    $comentario = $conn->real_escape_string($_POST['comentario']);

    $conn->query("INSERT INTO ventas (nombre_cliente, comentario, total) 
                 VALUES ('$nombre_cliente', '$comentario', 0)");
    $venta_id = $conn->insert_id;
    $total_venta = 0;

    //Procesamos los productos
    foreach ($_POST['producto_id'] as $index => $producto_id) {
        $producto_id = (int)$producto_id;
        $cantidad = (int)$_POST['cantidad'][$index];


        $result = $conn->query("SELECT precio FROM productos WHERE id = $producto_id");
        if ($result->num_rows === 0) {
            die("Error: Producto no encontrado");
        }

        $precio = $result->fetch_assoc()['precio'];
        $subtotal = $precio * $cantidad;
        $total_venta += $subtotal;

        //Insertamos el detalle de la venta
        $conn->query("INSERT INTO detalles_venta (venta_id, producto_id, cantidad, precio_unitario)
                      VALUES ($venta_id, $producto_id, $cantidad, $precio)");

        //Actualizamos el total de la venta principal
        $conn->query("UPDATE ventas SET total = $total_venta WHERE id = $venta_id");
    }
    $_SESSION['tipo_mensaje'] = "success";
    $_SESSION['mensaje'] = "Venta Agregada Correctamente";
    header("Location: lista.php");
    exit;
    var_dump($_POST);
}
?>

<body style="background-color: #f8f9fa;">

    <div class="centered-add">
        <div style="background-color: rgba(161, 161, 161, 0.41); border-radius: 6px; max-width: 700px; min-height: 500px;" class=" border-dark shadow d-flex flex-column container p-4">

            <h1 class="mt-1 text-center">Registrar Venta</h1>

            <div class="d-flex mx-auto mt-3">
                <form action="agregar.php" method="post">
                    <div class="mb-3">
                        <label for="nombre_cliente" class="form-label">Nombre del cliente</label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentario</label>
                        <textarea name="comentario" id="comentario" class="form-control"></textarea>
                    </div>

                    <div class="d-flex mb-3 justify-content-between align-content-center">
                        <h3 class="text-center m-0">Productos</h3>
                        <a href="#" class="add">Agregar</a>
                    </div>

                    <div id="productos-container">

                        <div class="producto-row d-flex gap-2 mb-2">
                            <select name="producto_id[]" class="form-select elproducto">
                                <?= $productos_options ?>
                            </select>
                            <input class="form-control lacantidad" name="cantidad[]" value="1" min="1" type="number" required>
                            <button type="button" class="btn btn-danger btn-sm delete-producto">&times;</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary flex-fill">Guardar venta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.querySelector(".add");
            const productosContainer = document.getElementById("productos-container");

            const productoHTML = `
                <div class="producto-row d-flex gap-2 mb-2">
                    <select name="producto_id[]" class="form-select elproducto">
                        <?= $productos_options ?>
                    </select>
                    <input class="form-control lacantidad" name="cantidad[]" placeholder="Cantidad" min="1" type="number" required>
                    <button type="button" class="btn btn-danger btn-sm delete-producto">&times;</button>
                </div>
            `;

            addBtn.addEventListener("click", function(e) {
                e.preventDefault();
                productosContainer.insertAdjacentHTML('beforeend', productoHTML);

                const deleteButtons = document.querySelectorAll('.delete-producto');
                deleteButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.parentElement.remove();
                    });
                });
            });

            productosContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-producto')) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
</body>