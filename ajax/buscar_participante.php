<?php
 	/*Version jul 18*/ 
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	
 	try {
 	    // Crear una nueva instancia de conexión PDO
        $pdo = new PDO($dsn);
        $sTable = "reu_participante";
 	    
 	    if (isset($_GET['id'])){
		   $id_participante=intval($_GET['id']);
		   $sql = "SELECT COUNT(*) AS cuantos FROM $sTable where numeroidparticipante=$id_participante";
           $stmt = $pdo->query($sql);
           // Obtener el resultado (única fila)
           $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
           // Número total de filas
           $cuantos = $resultado['cuantos'];
           if ($cuantos>0){
               //valida que no haya reuniones asignadas a la dependencia
               $sqlReu = "SELECT COUNT(*) AS cuantosreu FROM reu_reuniones_participante where numeroidparticipante=$id_participante";
               $stmtReu = $pdo->query($sqlReu);
               $resReu  = $stmtReu->fetch(PDO::FETCH_ASSOC);
               $cuantosReu = $resReu['cuantosreu'];
               
               if ($cuantosReu>0)
               {
        ?>           
                    <div class="alert alert-danger alert-dismissible" role="alert">
			            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			             <strong>Error!</strong> No se pudo eliminar el participante. Existen registros vinculados al participante. 
			        </div>
		<?php	        
               }
               else
               {
                  //borrar dependencia
                  // Consulta SQL de eliminación con marcador de posición   $id_participante
                  
                  $sql = "DELETE FROM $sTable WHERE numeroidparticipante = :numeroidparticipante";
                  $stmt = $pdo->prepare($sql);
                  // Vincular parámetro
                  $stmt->bindParam(':numeroidparticipante', $id_participante, PDO::PARAM_INT);
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
           
            $aColumns = array('nombresparticipante');//Columnas de busqueda
            $sTable = "reu_participante";
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
		    
		    $sWhere.=" group by tipodocumento, numeroidparticipante, nombresparticipante, celularparticipante, correoparticipante, departamento, ciudad, entidad, dependencia, cargo order by nombresparticipante";
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
				    <tr class="info">
				   	   <th>ID</th>
					   <th>Nombres</th>
					   <th>Celular</th>
					   <th>Correo</th>
					   <th>Entidad</th>
					   <th>Dependencia</th>
					   <th>Cargo</th>
					   <th class='text-center'>Acciones</th>
				    </tr>
        <?php    
         //aaa
                    $sql="SELECT * FROM  $sTable $sWhere OFFSET $offset LIMIT $per_page";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $numeroIdParticipante=$row['numeroidparticipante'];
  					    $nombresParticipante=$row['nombresparticipante'];
  					    $celularParticipante=$row['celularparticipante'];
  					    $correoParticipante=$row['correoparticipante'];
  					    $departamento=$row['departamento'];
  					    $ciudad=$row['ciudad'];
  					    $entidad=$row['entidad'];
  					    $dependencia=$row['dependencia'];
  					    $cargo=$row['cargo'];
  					    
  					    //trae entidad
					    $sqlEnt  ="select * from reu_entidades where identidad='$entidad'";
					   // echo $sqlEnt;
					    $stmtEnt = $pdo->query($sqlEnt);
					    $rowEnt  = $stmtEnt->fetch(PDO::FETCH_ASSOC);
					    $ent     = $rowEnt['nombreentidad'];
					    
					    //trae dependencia
					    $sqlDep  ="select * from reu_dependencias where iddependencia='$dependencia'";
					    $stmtDep = $pdo->query($sqlDep);
					    $rowDep  = $stmtDep->fetch(PDO::FETCH_ASSOC);
    				    $dep     = $rowDep['nombredependencia'];
  					    
						$lv   = $numeroIdParticipante. "/MOD1234567890qwertyuiopasdfghjkl";
					    $lVDX = base64_encode($lv);
               
                        //echo "Nombrexxxxxxx: {$row['nombreentidad']}<br />";
        ?>
                        <tr>	
  		   			       <td><?php echo $numeroIdParticipante; ?></td>
					       <td><?php echo $nombresParticipante; ?></td>
					       <td><?php echo $celularParticipante; ?></td>
					       <td><?php echo $correoParticipante; ?></td>
					       <td><?php echo $ent; ?></td>
					       <td><?php echo $dep; ?></td>
					       <td><?php echo $cargo; ?></td>
					   
   					       <td class='text-center'>
					         <a href="participante1.php?LA=<?=$lVDX?>" class='btn btn-default' title='Editar participante' ><i class="glyphicon glyphicon-edit"></i></a> 
					         <a href="#" class='btn btn-default' title='Borrar participante' onclick="eliminar('<?php echo $numeroIdParticipante; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					       </td>
					   </tr>
        <?php
                    }//while
        ?>
                       <tr>
					      <td colspan="8">
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
 	
 	