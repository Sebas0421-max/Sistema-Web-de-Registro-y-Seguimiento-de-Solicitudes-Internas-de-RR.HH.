<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$rol = $_SESSION['rol'];


// CONSULTA SEGÚN ROL
if ($rol == 'empleado') {

    $sql = "SELECT s.*, e.nombre_estado, u.nombre
            FROM solicitudes s
            INNER JOIN estados_solicitud e 
            ON s.id_estado = e.id_estado
            INNER JOIN usuarios u 
            ON s.id_usuario = u.id_usuario
            WHERE s.id_usuario = ?
            ORDER BY s.fecha_solicitud DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$id_usuario);

}else{

    $sql = "SELECT s.*, e.nombre_estado, u.nombre
            FROM solicitudes s
            INNER JOIN estados_solicitud e 
            ON s.id_estado = e.id_estado
            INNER JOIN usuarios u 
            ON s.id_usuario = u.id_usuario
            ORDER BY s.fecha_solicitud DESC";

    $stmt = $conn->prepare($sql);
}


$stmt->execute();
$resultado = $stmt->get_result();


// ICONOS
function iconoSolicitud($tipo){

    switch($tipo){

        case "Vacaciones":
            return "✈️";

        case "Enfermedad":
            return "✚";

        case "Estudios":
            return "🎓";

        case "Personal":
            return "👥";

        case "Maternidad":
            return "♡";

        case "Paternidad":
            return "👶";

        case "Cita Médica":
            return "⚕";

        case "Duelo":
            return "🖤";

        case "Mudanza":
            return "🏠";

        default:
            return "📄";
    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Solicitudes RRHH</title>


<style>

body{

    margin:0;
    background:#050b18;
    color:white;
    font-family:Arial, sans-serif;

}


.contenedor{

width:98%;
margin:30px auto;

}


h1{

    text-align:center;
    color:#00eaff;

}


/* FORMULARIO */

.formulario{

background:#101827;
padding:25px;
border-radius:15px;
margin-bottom:30px;

}


input,select,textarea{

width:100%;
padding:12px;
margin-top:8px;
border-radius:8px;
border:none;

}


textarea{

height:100px;

}


button{

background:linear-gradient(90deg,#00eaff,#e600ff);
border:none;
padding:12px;
width:100%;
border-radius:10px;
color:white;
font-weight:bold;

}


/* LISTADO */


.lista{

background:#07111f;
border-radius:15px;
overflow:hidden;
width:100%;

}



.encabezado,
.solicitud{

display:grid;

grid-template-columns:
2fr 1.2fr 1.2fr 0.8fr 1.8fr 1fr 2fr;

align-items:center;

padding:18px 20px;

width:100%;
box-sizing:border-box;

}


.encabezado{

color:#00eaff;
background:#0b1729;
font-size:14px;

}


.solicitud{

border-bottom:1px solid #18283d;

}


.tipo{

display:flex;
align-items:center;
gap:12px;

}


.icono{

width:35px;
height:35px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
background:#111d35;

}



/* ESTADOS */


.estado{

padding:6px 12px;
border-radius:15px;
font-size:12px;
width:max-content;

}


.pendiente{

color:#ffb000;
border:1px solid #ffb000;

}


.aprobada{

color:#00ff99;
border:1px solid #00ff99;

}


.rechazada{

color:#ff0066;
border:1px solid #ff0066;

}



/* BOTONES */


.acciones a{

text-decoration:none;
padding:7px 12px;
border-radius:6px;
font-size:12px;
margin-right:5px;

}


.aprobar{

border:1px solid #008cff;
color:#00aaff;

}


.rechazar{

border:1px solid #ff0080;
color:#ff0080;

}


.aprobar:hover{

background:#008cff;
color:white;

}


.rechazar:hover{

background:#ff0080;
color:white;

}


</style>


</head>


<body>


<div class="contenedor">


<a href="dashboard.php" style="color:#00eaff">
← Volver
</a>


<h1>Registro de Solicitudes</h1>



<?php if($rol=="empleado"){ ?>


<div class="formulario">

<h2>Nueva solicitud</h2>


<form action="guardar_solicitud.php" method="POST">


<label>Tipo de licencia:</label>

<select name="tipo_solicitud" required>


<option value="">Seleccione</option>

<option>Vacaciones</option>
<option>Enfermedad</option>
<option>Estudios</option>
<option>Personal</option>
<option>Maternidad</option>
<option>Paternidad</option>
<option>Cita Médica</option>
<option>Duelo</option>
<option>Mudanza</option>
<option>Otro</option>


</select>



<label>Asunto:</label>

<input type="text" name="asunto" required>


<label>Fecha de inicio:</label>
<input type="date" name="fecha_inicio" id="fecha_inicio" onchange="calcularDias()">


<label>Fecha de fin:</label>
<input type="date" name="fecha_fin" id="fecha_fin" onchange="calcularDias()">


<label>Cantidad de días:</label>
<input type="number" name="cantidad_dias" id="cantidad_dias" readonly>

<label>Descripción:</label>

<textarea name="descripcion" required></textarea>



<button>
Registrar solicitud
</button>



</form>

</div>


<?php } ?>



<div class="lista">


<div class="encabezado">

<div>Tipo de Licencia</div>
<div>Fecha Inicio</div>
<div>Fecha Fin</div>
<div>Días</div>
<div>Motivo</div>
<div>Estado</div>
<div>Acciones</div>

</div>



<?php while($fila=$resultado->fetch_assoc()){ ?>


<div class="solicitud">


<div class="tipo">


<div class="icono">

<?=iconoSolicitud($fila['tipo_solicitud'])?>

</div>


<?= $fila['tipo_solicitud'] ?>


</div>



<div>

<?= !empty($fila['fecha_inicio']) ? $fila['fecha_inicio'] : "-" ?>

</div>


<div>

<?= !empty($fila['fecha_fin']) ? $fila['fecha_fin'] : "-" ?>

</div>


<div>

<?= !empty($fila['cantidad_dias']) ? $fila['cantidad_dias']." días" : "-" ?>

</div>

<div>

<?= $fila['asunto'] ?>

</div>



<div>


<?php 

if($fila['id_estado']==1){

echo '<span class="estado pendiente">
Pendiente
</span>';

}

elseif($fila['id_estado']==2){

echo '<span class="estado aprobada">
Aprobada
</span>';

}

else{

echo '<span class="estado rechazada">
Rechazada
</span>';

}

?>


</div>



<div class="acciones">


<?php if(($rol=="rrhh" || $rol=="admin") && $fila['id_estado']==1){ ?>


<a class="aprobar"
href="cambiar_estado.php?id=<?=$fila['id_solicitud']?>&estado=2">

✓ Aprobar

</a>



<a class="rechazar"
href="cambiar_estado.php?id=<?=$fila['id_solicitud']?>&estado=3">

✕ Rechazar

</a>


<?php }else{ ?>


Sin acciones


<?php } ?>


</div>



</div>


<?php } ?>


</div>


</div>

<script>

function calcularDias(){

    let inicio = document.getElementById("fecha_inicio").value;
    let fin = document.getElementById("fecha_fin").value;


    if(inicio && fin){

        let fechaInicio = new Date(inicio);
        let fechaFin = new Date(fin);


        if(fechaFin < fechaInicio){

            alert("La fecha final no puede ser menor que la fecha inicial");

            document.getElementById("fecha_fin").value="";
            document.getElementById("cantidad_dias").value="";

            return;
        }


        let diferencia = fechaFin - fechaInicio;

        let dias = diferencia / (1000 * 60 * 60 * 24);

        document.getElementById("cantidad_dias").value = dias + 1;

    }

}

</script>

</body>

</html>