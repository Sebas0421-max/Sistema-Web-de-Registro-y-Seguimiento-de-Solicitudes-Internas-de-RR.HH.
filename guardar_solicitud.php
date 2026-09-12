<?php
session_start();
include 'db.php';

// 🔐 Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 📌 Captura de datos
    $id_usuario = $_SESSION['id_usuario'];
    $tipo_solicitud = $_POST['tipo_solicitud'] ?? '';
    $asunto = trim($_POST['asunto'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin = $_POST['fecha_fin'] ?? null;
    $cantidad_dias = $_POST['cantidad_dias'] ?? null;
    $id_estado = 1; // Pendiente por defecto

    // ❌ VALIDACIÓN 1: campos obligatorios
    if ($tipo_solicitud == '' || $asunto == '' || $descripcion == '') {
        die("❌ Error: Todos los campos obligatorios deben completarse.");
    }

    // ❌ VALIDACIÓN 2: tipo de solicitud con fechas obligatorias
    if ($tipo_solicitud == "Vacaciones" || $tipo_solicitud == "Permiso") {

        if (empty($fecha_inicio) || empty($fecha_fin)) {
            die("❌ Error: Debes seleccionar fecha de inicio y fin.");
        }

        // ❌ VALIDACIÓN 3: lógica de fechas
        if ($fecha_fin < $fecha_inicio) {
            die("❌ Error: La fecha fin no puede ser menor que la fecha inicio.");
        }

        // 🧮 cálculo de días si no viene del frontend
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);
        $cantidad_dias = $inicio->diff($fin)->days + 1;
    }

    // ❌ VALIDACIÓN 4: evitar valores negativos o inválidos
    if ($cantidad_dias !== null && $cantidad_dias <= 0) {
        die("❌ Error: La cantidad de días no es válida.");
    }

    // 💾 INSERT A BASE DE DATOS
    $sql = "INSERT INTO solicitudes 
            (id_usuario, tipo_solicitud, asunto, descripcion, fecha_inicio, fecha_fin, cantidad_dias, id_estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssssii",
        $id_usuario,
        $tipo_solicitud,
        $asunto,
        $descripcion,
        $fecha_inicio,
        $fecha_fin,
        $cantidad_dias,
        $id_estado
    );

    // 🚀 EJECUCIÓN
    if ($stmt->execute()) {
        header("Location: solicitudes.php?success=1");
        exit();
    } else {
        echo "❌ Error al guardar la solicitud: " . $conn->error;
    }
}
?>