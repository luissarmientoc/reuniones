<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	 
	if (isset($_GET['id'])){
		$id_identidad=intval($_GET['id']);
	}
	if($action == 'ajax'){
	
		 //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $ID=30;
		 $ENT="TTTTTTTTT";
		 
		 $sql = "INSERT INTO reu_entidades (identidad, nombreentidad) VALUES (:identidad, :nombreentidad)";
		 $stmt = $pdo->prepare($sql);
		 
		

		 // Asignar valores a los marcadores de posición y ejecutar la consulta
		 $stmt->bindParam(':identidad', $ID, PDO::PARAM_STR);
		 $stmt->bindParam(':apellido', $ENT, PDO::PARAM_STR);
		 $stmt->execute();
		 
		  
		 
		  
		
		// Limpiar y obtener el valor de 'q' de la solicitud ($_REQUEST)
          $q = strip_tags($_REQUEST['q'], ENT_QUOTES);
        
        // consulta preparada con PDO
        $sql = "SELECT * FROM $sTable WHERE columna = $q";
        echo $sql;
        
        
        
	}
	
?>