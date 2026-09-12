<?php
$servername = "localhost";
$username = "USUARIO_BD";
$password = "PASSWORD_BD";
$dbname = "rrhh_solicitudes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos");
}
?>
