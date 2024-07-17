<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	
 	try {
 	    // Crear una nueva instancia de conexión PDO
        $pdo = new PDO($dsn);
        $sTable = "reu_entidades";
 	    
 	    if (isset($_GET['id'])){
		   $id_identidad=intval($_GET['id']);
		   $sql = "SELECT COUNT(*) AS cuantos FROM $sTable where identidad=$id_identidad";
           $stmt = $pdo->query($sql);
           // Obtener el resultado (única fila)
           $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
           // Número total de filas
           $cuantos = $resultado['cuantos'];
           if ($cuantos>0){
               //borrar entidad
               // Consulta SQL de eliminación con marcador de posición
               $sql = "DELETE FROM $sTable WHERE identidad = :id_identidad";
               $stmt = $pdo->prepare($sql);
               // Vincular parámetro
               $stmt->bindParam(':id_identidad', $id_identidad, PDO::PARAM_INT);
    
               // Ejecutar la consulta
               $stmt->execute();
               
               // Verificar el número de filas afectadas (opcional)
               //$count = $stmt->rowCount();
           }
	    } 
        
        if($action == 'ajax')
        {
           
           // Limpiar y escapar la cadena de texto (strip_tags y htmlentities)
           $q = strip_tags($_REQUEST['q']);
           $q = htmlentities($q, ENT_QUOTES, 'UTF-8');
        
         echo '<br>';
         echo "la q..." . $q;
         echo '<br>';
         
            
            
            
           // Configurar el modo de error para excepciones
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   $sWhere = "";
		 
		   $sWhere.=" order by nombreentidad";
		   include 'pagination.php'; //include pagination file
		   //paginación variables
		   $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		   $per_page = 10; //cuantos registros desea mostrar
		   $adjacents  = 4; //gap entre paginas despues del número de adyacentes
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
           //echo "El número total de filas en la tabla es: $total_filas";
        
           if ($total_filas>0)
           {
       ?>
               <div class="table-responsive">
			     <table class='tablaResponsive table table-striped table-bordered table-hover'>
				   <tr  class="info">
				   	   <th>Entidad</th>
					   <th class='text-center'>Acciones</th>
				   </tr>
       <?php
                   // Consulta tabla base
                  //$sql="SELECT * FROM " . $sTable ;
               
                  $sql="SELECT * FROM  $sTable $sWhere OFFSET $offset LIMIT $per_page";
                  $stmt = $pdo->query($sql);
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                       $idEntidad=$row['identidad'];
				       $nombreEntidad=$row['nombreentidad'];
				       $lv   = $idEntidad. "/MOD1234567890qwertyuiopasdfghjkl";
				       $lVDX = base64_encode($lv);
               
                      //echo "Nombrexxxxxxx: {$row['nombreentidad']}<br />";
       ?>
                       <tr>	
  		   			      <td><?php echo $nombreEntidad; ?></td>
					   
   					      <td class='text-center'>
					        <a href="entidad1.php?LA=<?=$lVDX?>" class='btn btn-default' title='Editar entidad' ><i class="glyphicon glyphicon-edit"></i></a> 
					        <a href="#" class='btn btn-default' title='Borrar entidad' onclick="eliminar('<?php echo $idEntidad; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					       </td>
					   </tr>
       <?php
               }//while
       ?>        
                       <tr>
					      <td colspan="2">
					         <span class="pull-right">
					            <?php
					              echo paginate($reload, $page, $total_pages, $adjacents);
					            ?>
					          </span>
					      </td>
				       </tr>
			     </table>
	   <?php		  
            }//if
          }//ajax
 	}catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>