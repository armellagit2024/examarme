<?php
session_start();
require_once("../../conexion.php");

$id_proyecto = $_REQUEST["id_proyecto"];

echo"<html> 
       <head>
         <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
       </head>
       <body>";
//$db->debug=true;

/*
SELECT DISTINCT TABLE_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE COLUMN_NAME='id_material'
AND TABLE_SCHEMA='bd_presupuesto';
*/

/*LAS CONSULTAS SE TIENEN QUE HACER CON TODAS LAS TABLAS EN LAS QUE ID_CLINETE  ESTA COMO HERENCIA*/
$sql = $db->Prepare("SELECT *
                     FROM presupuestos
                     WHERE id_proyecto = ?
                     AND estado <> 'X'
                   ");
$rs = $db->GetAll($sql, array($id_proyecto));


if (!$rs) {
    $reg = array();
    $reg["estado"] = 'X';
    $reg["usuario"] = $_SESSION["sesion_id_usuario"];
    $rs1 = $db->AutoExecute("proyectos", $reg, "UPDATE", "id_proyecto='".$id_proyecto."'");
    header("Location:proyectos.php");
    exit();
    
} else {
    require_once("../../libreria_menu.php");
     echo"<div class='mensaje'>";
        $mensage = "NO SE ELIMINARON LOS DATOS DEL PROYECTO  PORQUE TIENE HERENCIA CON LA TABLA DE PRESUPUESTOS";
        echo"<h1>".$mensage."</h1>";
        
        echo"<a href='proyectos.php'>
                  <input type='button'style='cursor:pointer;border-radius:10px;font-weight:bold;height: 25px;' value='VOLVER>>>>'></input>
             </a>     
            ";
       echo"</div>" ;
}


echo"</body>
</html>";
?>
