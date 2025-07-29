<?php
session_start();
include("library/dbconfig.php");

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_POST) {
    $usuario = validate($_POST['usuario']);
    $clave = validate($_POST['clave']);

    if (empty($usuario)) {
        header("Location: index.php?error=El nombre de usuario es requerido");
        exit();
    } else if (empty($clave)) {
        header("Location: index.php?error=La contraseña es requerida");
        exit();
    }


    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($clave, $row['clave'])) {
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['id'] = $row['id'];
            header("Location: modules/inicio.php");
            exit();
        } else {
            header("Location: index.php?error=Contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: index.php?error=Usuario no encontrado");
        exit();
    }
}