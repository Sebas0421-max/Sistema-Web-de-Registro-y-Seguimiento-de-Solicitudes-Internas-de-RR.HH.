<?php
session_start();
if(isset($_SESSION['id_usuario'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Futurista - RRHH System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap');

        body {
            font-family: 'Orbitron', sans-serif;
            background: #0f0f1a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }

        .container {
            display: flex;
            width: 900px;
            box-shadow: 0 0 50px rgba(0,0,0,0.8);
            border-radius: 15px;
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            background: #111122;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #00f0ff;
            border-right: 2px solid #00f0ff;
        }

        .left-panel h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ff3cff;
        }

        .left-panel p {
            font-size: 14px;
            color: #aaa;
            margin-bottom: 30px;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .feature-icon {
            width: 30px;
            height: 30px;
            border: 2px solid #00f0ff;
            border-radius: 5px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
        }

        .feature-text {
            font-size: 14px;
        }

        .right-panel {
            flex: 1;
            background: #14142e;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .right-panel h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #00f0ff;
        }

        .input-field {
            margin-bottom: 20px;
        }

        .input-field input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #00f0ff;
            background: #1a1a2e;
            color: #fff;
            outline: none;
            transition: 0.3s;
        }

        .input-field input:focus {
            box-shadow: 0 0 10px #00f0ff;
            border-color: #ff3cff;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(90deg, #00f0ff, #ff3cff);
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.5s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #ff3cff, #00f0ff);
            box-shadow: 0 0 20px #ff3cff;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 15px;
            color: #555;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h1>SISTEMA DE GESTIÓN DE SOLICITUDES RRHH</h1>
            <p>Optimiza la gestión de solicitudes y mejora la productividad de tu equipo.</p>

            <div class="feature">
                <div class="feature-icon">💼</div>
                <div class="feature-text">Gestión Eficiente: Administra solicitudes rápido y seguro</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🔒</div>
                <div class="feature-text">Seguridad Avanzada: Protección de datos con estándares altos</div>
            </div>
            <div class="feature">
                <div class="feature-icon">📊</div>
                <div class="feature-text">Reportes Inteligentes: Insights y reportes en tiempo real</div>
            </div>
        </div>

        <div class="right-panel">
            <h2>INICIAR SESIÓN</h2>
            <form action="login_action.php" method="POST">
                <div class="input-field">
                    <input type="email" name="correo" placeholder="Correo electrónico" required>
                </div>
                <div class="input-field">
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                </div>
                <input type="submit" class="btn-login" value="Iniciar sesión">
            </form>
            <div class="footer">
                © 2026 Sistema RRHH. Todos los derechos reservados.
            </div>
        </div>
    </div>
</body>
</html>