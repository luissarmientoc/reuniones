<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
	{
          header("location: login.php");
	  exit;
        }
	
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="UNP | Inicio";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	<?php include("head.php");?>

  </head>
  
  <body>
 	<?php
	 include("dash.php");
	?>      
  </body>
</html>