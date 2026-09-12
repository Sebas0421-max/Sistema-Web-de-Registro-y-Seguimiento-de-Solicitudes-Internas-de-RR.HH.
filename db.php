<?php
$servername = "localhost";
$username = "NOMBRE DE USUARIO";
$password = "CONTRASEÑA";
$dbname = "rrhh_solicitudes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
