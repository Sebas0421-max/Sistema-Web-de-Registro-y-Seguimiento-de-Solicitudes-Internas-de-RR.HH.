<?php
session_start();
include 'db.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$rol = $_SESSION['rol'];

// Consultas dinámicas según rol
if ($rol == 'admin') {
    $pendientes = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=1")->fetch_row()[0];
    $aprobadas = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=2")->fetch_row()[0];
    $rechazadas = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=3")->fetch_row()[0];
    $total_usuarios = $conn->query("SELECT COUNT(*) FROM usuarios")->fetch_row()[0];
}

if ($rol == 'rrhh') {
    $pendientes = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=1")->fetch_row()[0];
    $aprobadas = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=2")->fetch_row()[0];
    $rechazadas = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=3")->fetch_row()[0];
    $total_usuarios = '-';
}

if ($rol == 'empleado') {
    $pendientes = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=1 AND id_usuario=$id_usuario")->fetch_row()[0];
    $aprobadas = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=2 AND id_usuario=$id_usuario")->fetch_row()[0];
    $rechazadas = $conn->query("SELECT COUNT(*) FROM solicitudes WHERE id_estado=3 AND id_usuario=$id_usuario")->fetch_row()[0];
    $total_usuarios = '-';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema RRHH</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap');

        body { margin:0; font-family:'Orbitron', sans-serif; background:#0f0f1a; color:#fff; }
        .sidebar { position:fixed; left:0; top:0; width:220px; height:100%; background:#111122; border-right:2px solid #00f0ff; padding:20px; }
        .sidebar h2 { color:#ff3cff; text-align:center; margin-bottom:40px; }
        .sidebar a { display:block; color:#00f0ff; text-decoration:none; margin:15px 0; padding:10px; border-radius:8px; transition:0.3s; }
        .sidebar a:hover { background:#00f0ff; color:#111122; box-shadow:0 0 15px #00f0ff; }
        .main { margin-left:240px; padding:40px; }
        .welcome { font-size:24px; margin-bottom:30px; color:#00f0ff; }
        .cards { display:flex; gap:20px; flex-wrap:wrap; }
        .card { background:#1a1a2e; flex:1 1 200px; padding:20px; border-radius:15px; box-shadow:0 0 20px rgba(0,255,255,0.3); transition:0.3s; }
        .card:hover { box-shadow:0 0 40px #ff3cff; transform:translateY(-5px); }
        .card h3 { margin-top:0; color:#ff3cff; }
        .card p { font-size:16px; color:#00f0ff; }
        .logout-btn { display:inline-block; margin-top:30px; padding:10px 20px; background:linear-gradient(90deg,#00f0ff,#ff3cff); border-radius:8px; color:#111122; font-weight:bold; text-decoration:none; transition:0.5s; }
        .logout-btn:hover { background:linear-gradient(90deg,#ff3cff,#00f0ff); box-shadow:0 0 20px #ff3cff; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>RRHH SYSTEM</h2>

    <?php if($rol == 'admin') { ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="#">Gestionar Usuarios</a>
        <a href="solicitudes.php">Ver Solicitudes</a>
        <a href="#">Reportes</a>
    <?php } ?>

    <?php if($rol == 'rrhh') { ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="solicitudes.php">Solicitudes Pendientes</a>
        <a href="#">Aprobar/Rechazar</a>
    <?php } ?>

    <?php if($rol == 'empleado') { ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="solicitudes.php">Registrar Solicitud</a>
        <a href="#">Mis Solicitudes</a>
    <?php } ?>

    <a href="logout.php">Cerrar Sesión</a>
</div>

<div class="main">
    <div class="welcome">
        Bienvenido, <?php echo $_SESSION['nombre']; ?>! <br>
        Rol: <?php echo $_SESSION['rol']; ?>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Solicitudes Pendientes</h3>
            <p><?php echo $pendientes; ?></p>
        </div>
        <div class="card">
            <h3>Solicitudes Aprobadas</h3>
            <p><?php echo $aprobadas; ?></p>
        </div>
        <div class="card">
            <h3>Solicitudes Rechazadas</h3>
            <p><?php echo $rechazadas; ?></p>
        </div>
        <div class="card">
            <h3>Total de Usuarios</h3>
            <p><?php echo $total_usuarios; ?></p>
        </div>
    </div>

    <a href="logout.php" class="logout-btn">Cerrar sesión</a>
</div>

</body>
</html>