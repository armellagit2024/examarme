<?php
session_start();
require_once("../../conexion.php");
require_once("../../paginacion.inc.php");
require_once("../../libreria_menu.php");
// $db->debug=true;

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Listado de Proyectos</title>
    <link rel='stylesheet' href='../../bootstrap/css/bootstrap.min.css'>
    <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
    <style>
        .table-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }

        .btn-custom {
            margin: 0 5px;
        }

        .pagination-container {
            margin-top: 20px;
            text-align: center;
        }

        .btn-link {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class='container my-4'>
        <h1 class='my-4'>Listado de Proyectos</h1>";

contarRegistros($db, "proyectos");
paginacion("proyectos.php?");

$sql = $db->Prepare("SELECT *
                     FROM proyectos
                     WHERE estado <> 'X'
                     ORDER BY id_proyecto ASC
                     LIMIT ? OFFSET ?");
$rs = $db->GetAll($sql, array($nElem, $regIni));

if ($rs) {
    echo "<div class='table-container'>
            <a href='proyecto_nuevo.php' class='btn btn-primary mb-3'>Nuevo Proyecto</a>
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Nro</th>
                        <th>Nombre</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>";

    $b = 0;
    $total = $pag - 1;
    $a = $nElem * $total;
    $b = $b + 1 + $a;

    foreach ($rs as $k => $fila) {
        echo "<tr>
                <td class='text-center'>".$b."</td>
                <td class='text-center'>".$fila['nombre']."</td>
                <td>".$fila['fec_inicio']."</td>
                <td>".$fila['fec_fin']."</td>
                <td class='text-center'>
                    <form name='formModif".$fila["id_proyecto"]."' method='post' action='proyecto_modificar.php'>
                        <input type='hidden' name='id_proyecto' value='".$fila['id_proyecto']."'>
                        <button type='submit' class='btn btn-warning btn-custom'>
                            Modificar
                        </button>
                    </form>
                </td>
                <td class='text-center'>
                    <form name='formElimi".$fila["id_proyecto"]."' method='post' action='proyecto_eliminar.php'>
                        <input type='hidden' name='id_proyecto' value='".$fila["id_proyecto"]."'>
                        <button type='button' class='btn btn-danger btn-custom' onclick='if(confirm(\"Desea realmente eliminar el proyecto ".$fila["nombre"]." ?\")) { document.forms[\"formElimi".$fila["id_proyecto"]."\"].submit(); }'>
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>";
        $b = $b + 1;
    }

    echo "</tbody>
        </table>
    </div>";

    mostrar_paginacion();
}

echo "</div>
    <script src='../../bootstrap/js/jquery-3.7.1.min.js'></script>
    <script src='../../bootstrap/js/bootstrap.bundle.min.js'></script>
</body>
</html>";
?>
