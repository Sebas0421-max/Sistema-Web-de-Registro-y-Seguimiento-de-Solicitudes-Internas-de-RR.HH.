<?php
session_start();
include 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $correo = $conn->real_escape_string($_POST['correo']);
    $contraseña = $_POST['contraseña'];

    // Consultar usuario
    $sql = "SELECT id_usuario, nombre, rol, contraseña FROM usuarios WHERE correo='$correo' AND estado=1";
    $result = $conn->query($sql);

    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        // Verificar contraseña (si usas password_hash, aquí cambiarías a password_verify)
        if($row['contraseña'] === $contraseña){
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado o inactivo.";
    }
}
?>