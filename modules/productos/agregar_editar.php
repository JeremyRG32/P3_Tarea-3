<?php
include('../../library/auth.php');
include("../../library/layout.php");
plantilla::aplicar();
$action = "Agregar";

$producto = [
    "id" => null,
    "nombre" => "",
    "precio" => ""
];

if (isset($_GET['id'])) {
    $action = "Editar";
    $id = $_GET['id'];

    $producto = $conn->query("SELECT * FROM productos WHERE id = $id");

    if (!$producto) {
        die("Invalid query: " . $conn->error);
    }

    $producto = $producto->fetch_assoc();

    $id = $producto['id'];
    $nombre = $producto['nombre'];
    $precio = $producto['precio'];
}

if ($_POST) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    if (empty($id)) {
        $sql = "INSERT INTO productos (nombre, precio) 
        VALUES('$nombre', $precio);";
    } else{
        $sql = "UPDATE productos
        SET nombre = '$nombre', precio = $precio
        WHERE id = $id";
    }

    $result = $conn->query($sql);

    if (!$result) {
        $_SESSION['mensaje'] = "Error al guardar el producto.";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: lista.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Producto guardado exitosamente.";
        $_SESSION['tipo_mensaje'] = "success";
        header("Location: lista.php");
        exit();
    }
}

?>

<body>
    <div class="centered-add">
        <form class="p-5 m-5 shadow rounded-2 bg-white" method="post" action="agregar_editar.php">
            <h1 class="text-center"><?= $action ?> Producto</h1>

            <input class="form-control" value="<?=$producto['id']?>" name="id" hidden>

            <label class="form-label">Nombre</label>
            <input class="form-control" name="nombre" value="<?= $producto['nombre'] ?>" placeholder="Ej: Jugo, Refresco">

            <label class="form-label">Precio</label>
            <input class="form-control" type="number" name="precio" value="<?= $producto['precio'] ?>" placeholder="100">

            <div class="d-flex justify-content-between">
                <button style="width: 200px;" class="btn btn-primary mt-3" type="submit">Guardar</button>
                <a style="width: 200px;" href="lista.php" class="btn btn-secondary mt-3" type="submit">Volver</a>
            </div>
        </form>
    </div>
</body>