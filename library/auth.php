<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /index.php?error=Debe iniciar sesión");
    exit();
}
?>