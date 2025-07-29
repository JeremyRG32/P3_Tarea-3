<?php
ob_start();
$host = "localhost";
$username = "root";       
$password = "1234";  
$database = "larubia_db";

$conn = new mysqli($host, $username, $password, "");

if ($conn->connect_error) {
    die("<div class='alert alert-danger'>Conexión fallida: " . $conn->connect_error . "</div>");
}

if (file_exists('instalado.lock')) {
    die("<div class='alert alert-warning'>⚠️ El sistema ya está instalado.</div>");
}

// Creamos y seleccionamos la base de datos
$sql = "CREATE DATABASE IF NOT EXISTS larubia_db";
if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>✔️ Base de datos creada correctamente</div>";
} else {
    die("<div class='alert alert-danger'>Error al crear la base de datos: " . $conn->error . "</div>");
}

$conn->select_db("larubia_db");

// Creamos la tabla usuarios
$sql = "CREATE TABLE IF NOT EXISTS usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    clave VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>✔️ Tabla 'usuarios' creada correctamente</div>";
} else {
    die("<div class='alert alert-danger'>Error al crear la tabla usuarios: " . $conn->error . "</div>");
}

// Insertamos usuario demo si no existe
$usuario = "demo";
$clave = password_hash("tareafacil25", PASSWORD_DEFAULT);
$result = $conn->query("SELECT * FROM usuarios WHERE usuario = 'demo'");

if ($result->num_rows == 0) {
    $sql = "INSERT INTO usuarios (usuario, clave) VALUES ('$usuario', '$clave')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>✔️ Usuario 'demo' creado con clave <strong>tareafacil25</strong></div>";
    } else {
        die("<div class='alert alert-danger'>Error al crear el usuario demo: " . $conn->error . "</div>");
    }
} else {
    echo "<div class='alert alert-info'>ℹ️ El usuario demo ya existe</div>";
}

// Creamos la tabla productos
$sql = "CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
)";
if($conn->query($sql) === TRUE){
    echo "<div class='alert alert-success'>✔️ Tabla 'productos' creada correctamente</div>";
} else {
    die("<div class='alert alert-danger'>Error al crear la tabla productos: " . $conn->error . "</div>");
}

// Creamos la tabla ventas
$sql = "CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    comentario VARCHAR(255) NULL
)";
if($conn->query($sql) === TRUE){
    echo "<div class='alert alert-success'>✔️ Tabla 'ventas' creada correctamente</div>";
} else {
    die("<div class='alert alert-danger'>Error al crear la tabla ventas: " . $conn->error . "</div>");
}

// Creamos la tabla detalles_venta
$sql = "CREATE TABLE IF NOT EXISTS detalles_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT,
    producto_id INT,
    cantidad INT,
    precio_unitario DECIMAL(10,2),
    FOREIGN KEY (venta_id) REFERENCES ventas(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
)";
if($conn->query($sql) === TRUE){
    echo "<div class='alert alert-success'>✔️ Tabla 'detalles_venta' creada correctamente</div>";
} else {
    die("<div class='alert alert-danger'>Error al crear la tabla detalles_venta: " . $conn->error . "</div>");
}

echo "<div class='alert alert-primary'>🎉 Creación de la base de datos completada</div>";

file_put_contents('instalado.lock', 'INSTALADO');
$conn->close();
$content = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalación - La Rubia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Instalador del sistema La Rubia</h3>
            </div>
            <div class="card-body">
                <?= $content ?>
                <a class="btn btn-primary d-flex text-center mx-auto" href="../index.php">Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>