<?php
include('../../library/auth.php');
include("../../library/layout.php");
plantilla::aplicar();

$sql = "SELECT * FROM productos";
$productos = $conn->query($sql);

if (!$productos) {
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
            <h1>Lista de Productos</h1>
            <a href="agregar_editar.php" class="btn btn-primary">Agregar</a>
        </div>

        <div class="row g-3 text-center">
            <?php
            foreach ($productos as $p) { ?>
                <div class="col-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?=$p['nombre']?></h5>
                            <h5 class="card-text fw-bold text-success">RD$<?=$p['precio']?></h5>
                        </div>
                        <div class="d-flex mt-auto gap-2 px-2 py-2">
                            <a href="agregar_editar.php?id=<?=$p['id']?>" class="btn btn-sm btn-primary flex-fill">Editar</a>
                            <a href="eliminar.php?id=<?=$p['id']?>" class="btn btn-sm btn-danger flex-fill">Eliminar</a>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>

</body>