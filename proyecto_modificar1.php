<?php
session_start();
require_once("../../conexion.php");
//require_once("../../libreria_menu.php");

$db->debug=true;

echo"<html> 
       <head>
         <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
       </head>
       <body>";
       
$id_proyecto = $_POST["id_proyecto"];
$nombre = $_POST["nombre"];
$fec_inicio = $_POST["fec_inicio"];
$fec_fin = $_POST["fec_fin"];


if(($nombre!="")and($fec_inicio!="")and($fec_fin!="")){
   $reg = array();
   $reg["nombre"] = $nombre;
   $reg["fec_inicio"] = $fec_inicio;
   $reg["fec_fin"] = $fec_fin;
  
   $reg["fec_insercion"] = date("Y-m-d H:i:s");
   $reg["fec_modificacion"] = date("Y-m-d H:i:s");
   $reg["usuario"] = $_SESSION["sesion_id_usuario"];   
   $reg["estado"] = 'A';

   
   $reg["usuario"] = $_SESSION["sesion_id_usuario"];   
   $rs1 = $db->AutoExecute("proyectos", $reg, "UPDATE", "id_proyecto='".$id_proyecto."'");
   header("Location: proyectos.php");
   exit();
} else {
        require_once("../../libreria_menu.php");
      echo"<div class='mensaje'>";
        $mensage = "NO SE MODIFICARON LOS DATOS DEL PROYECTO";
        echo"<h1>".$mensage."</h1>";
        
        echo"<a href='proyectos.php'>
                  <input type='button'style='cursor:pointer;border-radius:10px;font-weight:bold;height: 25px;' value='VOLVER>>>>'></input>
             </a>     
            ";
       echo"</div>" ;
   }

echo "</body>
      </html> ";
?> 