<?php
    echo '<br>';
    echo "entra a uno..";
    echo '<br>';
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	
 	try {
      echo '<br>';
      echo "try";
      // Cadena de conexión
      //$dsn = "pgsql:host=$POSTGRESQL_HOST;port=$POSTGRESQL_PORT;dbname=$POSTGRESQL_NAME;user=$POSTGRESQL_USER;password=$POSTGRESQL_PASS";
       echo '<br>';  
       echo "linea.." . $dsn;
      echo '<br>';
       // Crear una nueva instancia de conexión PDO
      $pdo = new PDO($dsn);
    
    // Configurar el modo de error para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conectado: ";
	    $sTable = "reu_entidades";
		$sWhere = "";
		 
		$sWhere.=" order by nombreentidad";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		
	    // Consulta SQL para contar las filas
        $sql = "SELECT COUNT(*) AS total_filas FROM $sTable";
        $stmt = $pdo->query($sql);
        // Obtener el resultado (única fila)
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // Número total de filas
        $total_filas = $resultado['total_filas'];
        $total_pages = ceil($total_filas / $per_page);
        $reload = './marcas.php';
        
        echo "El número total de filas en la tabla es: $total_filas";
        
        // Consulta tabla base
        $sql="SELECT * FROM " . $sTable ;
        $stmt = $pdo->query($sql);
           while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               echo "Nombre: {$row['nombreentidad']}<br />";
        }
        
        
 	}catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

        
        
	
	
?>