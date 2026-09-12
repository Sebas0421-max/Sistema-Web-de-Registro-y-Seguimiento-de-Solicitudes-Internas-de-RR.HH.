<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if (!in_array($_SESSION['rol'], ['admin','rrhh'])) {
    die("No autorizado");
}

if (!isset($_GET['id']) || !isset($_GET['estado'])) {
    die("Parámetros inválidos");
}

$id = intval($_GET['id']);
$estado = intval($_GET['estado']);

if (!in_array($estado, [1,2,3])) {
    die("Estado inválido");
}

$sql = "UPDATE solicitudes SET id_estado=? WHERE id_solicitud=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $estado, $id);

$stmt->execute();

header("Location: solicitudes.php");
exit();
?>