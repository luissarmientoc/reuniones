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
  $title="UNP | Anexo Mesa Técnic";    
  $nombreUsuario = $_SESSION['user_firstname'] ." " .$_SESSION['user_lastname']; 
?>

<html lang="en">
  <head>
    <?php 
      require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
      require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
      // require("modal.php");
       include("head.php");
    ?>

 
   </head>
   
   <?php  
      include("navbar.php");
      // Crear una nueva instancia de conexión PDO
         $pdo = new PDO($dsn);
         
          try {
         $nombre="LOS DEPENDENCIA";
         $laId=1;
      
         $stmt = $pdo->prepare('
                       UPDATE reu_dependencias
                       SET  nombredependencia = ?, iddependencia = ?');   
        
        // Ejecutar la consulta con los valores correspondientes
        $stmt->execute([
        $nombre, $laId
                   ]);
          echo "Datos actualizados correctamente.";
            } catch (PDOException $e) {
                  echo "Error al actualizar los datos del anexo: " . $e->getMessage();
            }
          
       
    ?>   