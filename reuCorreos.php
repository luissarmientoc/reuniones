<?php
 
  session_start();
  /*
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
  {
    header("location: login.php");
    exit;
  }
  */
  
  $active_marca="active";
  $title="UNP | Reuniones";  
  $nombreUsuario = $_SESSION['user_firstname'] ." " .$_SESSION['user_lastname']; 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
 <?php 
     require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
     require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
     include("head.php");
  ?>
  </head>
  
  <?php  
   include("navbar.php");
    // Crear una nueva instancia de conexión PDO
    $pdo = new PDO($dsn);
   
    $s_LA    = $_GET['LA'];
    $linDeco = base64_decode($s_LA);
   
    //PARTE LA LINEA
    $partir      = explode ("/", $linDeco);   
    
    $s_idReunion   = $partir[0];
    $tipAccion     = $partir[1];
    
    if ( $s_idReunion != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "MODIFICAR REUNION";
      $s_existe = 1;
      $boton  = "Actualizar";
    
      $sql = "select * from reu_reuniones where idreunion=$s_idReunion";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
    
      $s_idReunion       = $row['idreunion'];
      $s_fechaReunion    = $row['fechareunion'];
      $s_horaReunion     = $row['horareunion'];
      $s_lugarReunion    = $row['lugarreunion'];
      $s_convocadaPor    = $row['convocadapor'];
      $s_idEntidad       = $row['identidad'];
      $s_idDependencia   = $row['iddependencia'];
      $s_idGrupo         = $row['idgrupo'];
      $s_idCategoria     = $row['idcategoria'];
      $s_idSubCategoria  = $row['idsubcategoria'];
      $s_detalleReunion  = $row['detallereunion'];
      $s_desarrolloReunion = $row['desarrolloreunion'];
      $s_estadoReunion   = $row['estadoreunion'];
      $s_fechaEstado     = $row['fechaestado'];
        
         
        echo "1.." . $s_idReunion;
        echo '<br>';
        echo "2.." . $s_fechaReunion;
        echo '<br>';
        echo "3.." . $s_horaReunion;
        echo '<br>';
        echo "4.." . $s_lugarReunion;
        echo '<br>';
        echo "5.." . $s_convocadaPor;
        echo '<br>';
        echo "6.." . $s_idEntidad;
        echo '<br>';
        echo "7.." . $s_idDependencia;
        echo '<br>';
        echo "8.." . $s_idGrupo;
        echo '<br>';
        echo "9.." . $s_idCategoria;
        echo '<br>';
        echo "10.." . $s_idSubCategoria;
        echo '<br>';
        echo "11.." . $s_detalleReunion;
        echo '<br>';
        echo "11 a.." . $s_desarrolloReunion;
        echo '<br>';
        echo "12.." . $s_estadoReunion;
        echo '<br>';
        echo "13.." . $s_fechaEstado;
        echo '<br>';

    }  

 ?>    