<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	
 	try {
 	    // Crear una nueva instancia de conexión PDO
        $pdo = new PDO($dsn);
        $sTable = "reu_sub_categorias";
 	    
 	    if (isset($_GET['id'])){
		   $id_subcategoria=intval($_GET['id']);
		   $sql = "SELECT COUNT(*) AS cuantos FROM $sTable where idsubcategoriareunion=$id_subcategoria";
           $stmt = $pdo->query($sql);
           // Obtener el resultado (única fila)
           $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
           // Número total de filas
           $cuantos = $resultado['cuantos'];
           if ($cuantos>0){
               //valida que no haya reuniones asignadas a la dependencia
               $sqlReu     = "SELECT COUNT(*) AS cuantosReu FROM reu_reuniones where idsubcategoria=$id_subcategoria";
               $stmtReu    = $pdo->query($sqlReu);
               $resReu     = $stmtReu->fetch(PDO::FETCH_ASSOC);
               $cuantosReu = $resReu['cuantosReu'];
               
               if ($cuantosReu>0)
               {
        ?>           
                    <div class="alert alert-danger alert-dismissible" role="alert">
			            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			             <strong>Error!</strong> No se pudo eliminar ésta subcategoría. Existen registros vinculados a ésta subcategoría. 
			        </div>
		<?php	        
               }
               else
               {
                  //borrar dependencia
                  // Consulta SQL de eliminación con marcador de posición
                  $sql = "DELETE FROM $sTable WHERE idsubcategoriareunion = :id_subcategoria";
                  $stmt = $pdo->prepare($sql);
                  // Vincular parámetro
                  $stmt->bindParam(':id_subcategoria', $id_subcategoria, PDO::PARAM_INT);
                  // Ejecutar la consulta
                  $stmt->execute();
                  // Verificar el número de filas afectadas (opcional)
                  $borradas = $stmt->rowCount();
                  if ($borradas>0){
        ?>
                      <div class="alert alert-success alert-dismissible" role="alert">
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                <strong>Atención!</strong> Datos eliminados exitosamente.
			           </div>
        <?php
                  }
                  else{
        ?>              
                     <div class="alert alert-danger alert-dismissible" role="alert">
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			           <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			         </div> 
		<?php	
                  }
                  
               } 
           }//cuantos>0
	    }
	    //aqui va ajax
	    if($action == 'ajax'){
	        // Limpiar y escapar la cadena de texto (strip_tags y htmlentities)
            $q = strip_tags($_REQUEST['q']);
            $q = htmlentities($q, ENT_QUOTES, 'UTF-8');
        
            /*echo '<br>';
            echo "la q..." . $q;
            echo '<br>';*/
            $q = strtoupper($q);
           
            $aColumns = array('subcategoriareunion');//Columnas de busqueda
            $sTable = "reu_sub_categorias";
		    $sWhere = "";
		 
		    $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
		    }
		    $sWhere = substr_replace( $sWhere, "", -3 );
		    $sWhere .= ')'; 
		    
		    // Configurar el modo de error para excepciones
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $sWhere.=" group by idsubcategoriareunion, subcategoriareunion order by subcategoriareunion";
		    include 'pagination.php'; //include pagination file
		    //paginación variables
		    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		    $per_page = 10; //cuantos registros desea mostrar
		    $adjacents  = 4; //gap entre paginas despues del número de adyacentes
		    $offset = ($page - 1) * $per_page;
		
	        // Consulta SQL para contar las filas
            $sql = "SELECT COUNT(*) AS total_filas FROM $sTable $sWhere";
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
				   	   <th>Subcategorías</th>
					   <th class='text-center'>Acciones</th>
				    </tr>
        <?php    
                    $sql="SELECT * FROM  $sTable $sWhere OFFSET $offset LIMIT $per_page";
                    echo $sql;
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $idSubcategoria=$row['idsubcategoriareunion'];
						$nombreSubcategoria=$row['subcategoriareunion'];
						 
 					    $lv   = $idSubcategoria. "/MOD1234567890qwertyuiopasdfghjkl";
					    $lVDX = base64_encode($lv);
        ?>
                        <tr>	
  		   			      <td><?php echo $nombreSubcategoria; ?></td>
					   
   					      <td class='text-center'>
					        <a href="subcategorias1.php?LA=<?=$lVDX?>" class='btn btn-default' title='Editar subcategoría' ><i class="glyphicon glyphicon-edit"></i></a> 
					        <a href="#" class='btn btn-default' title='Borrar subcategoría' onclick="eliminar('<?php echo $idSubcategoria; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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
            }// if>0
	    }//ajax
 	}catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}    
 	 
	
?>