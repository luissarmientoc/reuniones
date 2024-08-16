<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	echo 'entra';
   	
 	try {
 	    // Crear una nueva instancia de conexión PDO
        $pdo = new PDO($dsn);
        $sTable = "reu_reuniones";
        
        if (isset($_GET['id'])){
		   $id_reunion=intval($_GET['id']);
		   $sql = "SELECT COUNT(*) AS cuantos FROM $sTable where idreunion=$id_reunion";
           $stmt = $pdo->query($sql);
           // Obtener el resultado (única fila)
           $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
           // Número total de filas
           $cuantos = $resultado['cuantos'];
           if ($cuantos>0){
               //valida que no haya reuniones asignadas a la dependencia
               $sqlReu = "SELECT COUNT(*) AS cuantosReu FROM reu_reuniones_participante where idreunion=$id_reunion";
               $stmtReu = $pdo->query($sqlReu);
               $resReu  = $stmtReu->fetch(PDO::FETCH_ASSOC);
               $cuantosReu = $resReu['cuantosReu'];
               
               if ($cuantosReu>0)
               {
        ?>           
                    <div class="alert alert-danger alert-dismissible" role="alert">
			            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			             <strong>Error!</strong> No se pudo eliminar ésta reunion. Existen registros vinculados a ésta reunión. 
			        </div>
		<?php	        
               }
               else
               {
                  //borrar reunión
                  // Consulta SQL de eliminación con marcador de posición
                  $sql = "DELETE FROM $sTable WHERE idreunion = :id_reunion";
                  $stmt = $pdo->prepare($sql);
                  // Vincular parámetro
                  $stmt->bindParam(':id_reunion', $id_reunion, PDO::PARAM_INT);
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
               
           }//cuantos
           
        }//get   
        //aqui va ajax
	    if($action == 'ajax'){
	        // Limpiar y escapar la cadena de texto (strip_tags y htmlentities)
            $q_str = isset($_REQUEST['q']) ? strip_tags($_REQUEST['q']) : ''; 
            $q = intval($q_str); // Convierte $q_str a entero
            
            $q1_str = isset($_REQUEST['q1']) ? strip_tags($_REQUEST['q1']) : ''; 
            $q1 = intval($q1_str); // Convierte $q1_str a entero
            
            $q2_str = strip_tags($_REQUEST['q2']);
            $q2 = htmlentities($q2_str, ENT_QUOTES, 'UTF-8');// Convierte $q2_str a entero
            
            $q3_str = isset($_REQUEST['q3']) ? strip_tags($_REQUEST['q3']) : ''; 
            $q3 = intval($q3_str); // Convierte $q3_str a entero
            
            $q4_str = isset($_REQUEST['q4']) ? strip_tags($_REQUEST['q4']) : ''; 
            $q4 = intval($q4_str); // Convierte $q4_str a entero
            
            $q4_str = isset($_REQUEST['q5']) ? strip_tags($_REQUEST['q5']) : ''; 
            $q4 = intval($q5_str); // Convierte $q5_str a entero
            
            /*
             echo '<br>';
             echo "q: " . $q;
             
             echo '<br>';
             echo "q1: " . $q1;
             echo '<br>';
             echo "q2: " . $q2;
             echo '<br>';
             echo "q3: " . $q3;
             echo '<br>';
            */
            if ($q==0)
            {
               if ($q1==0)
               {
                    if($q2!="")
                    {
                        if($q3==0)
                        {
                            if($q4==0)
                            {
                                if($q5==0)
                                {
                                    $sWhere = "";
                                    $sWhere1 = "";
                                }
                                else
                                {
                                   $sWhere = "where ";
                                   $sWhere1 = "where ";
                                }
                            }
                        }
                    }
                }
            }      
             
            if ($q==0 and $q1==0 and $q2=="" and $q3==0 and $q4==0 and $q5==0 ) {
                $sWhere = "";
                $sWhere1 = "";
            }
            else
            {
                $sWhere = "where ";
                $sWhere1 = "where ";
            }
             
            /*  
            if ($q!="")
            {
              $aColumns = array('fechareunion');//Columnas de busqueda
            }
            else
            {
             $aColumns = "";
            }
            */
            
            $sTable = "graerr_formulario_b";
            /*
		    $sWhere = "where ";
		    $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
				//$sWhere .= $aColumns[$i]." = ".$q." OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
			*/
		
		    ///////////
		    
		
		  	if ($q>0){
		        $sWhere .=" registro ='$q'";
		        $sWhere1 .=" registro ='$q'";
		    }
		  	
		  	if ($q1>0){
		  	    if ($q>0)
		        {
		          $sWhere .=" and no_documento ='$q1'";
		          $sWhere1 .=" and no_documento ='$q1'";
		        }    
		        else
		        {
		          $sWhere .=" no_documento ='$q1'";
		          $sWhere1 .=" no_documento ='$q1'";
		        }    
		    }
		    
		    
		    if ($q2!=''){
		        $q2M= strtoupper($q2);
		        if ($q1>0)
		        {
		          $sWhere .=" and nombres_peticionario LIKE '%".$q2M."%' OR apellidos_peticionario LIKE '%".$q2M."%'";
		          $sWhere1 .=" and nombres_peticionario LIKE '%".$q2M."%' OR apellidos_peticionario LIKE '%".$q2M."%'";    
		        }
		        else
		        {
		          $sWhere .=" nombres_peticionario LIKE '%".$q2M."%' OR apellidos_peticionario LIKE '%".$q2M."%'";
		          $sWhere1 .=" nombres_peticionario LIKE '%".$q2M."%' OR apellidos_peticionario LIKE '%".$q2M."%'";
		        }    
		    }
		    if ($q3>0){
		        if ($q2!='')
		        {
		          $sWhere .=" and tipo_ruta ='$q3'";
		          $sWhere1 .=" and tipo_ruta ='$q3'";    
		        }
		        else
		        {
		            $sWhere .=" tipo_ruta ='$q3'";
		            $sWhere1 .="tipo_ruta ='$q3'";
		        }
		    }
		    if ($q4>0){
		        if ($q3>0)
		        {
		          $sWhere .=" and analista_riesgo ='$q4'";
		          $sWhere1 .=" and analista_riesgo ='$q4'";    
		        }
		        else
		        {
		            $sWhere .=" analista_riesgo ='$q4'";
		            $sWhere1 .=" analista_riesgo ='$q4'";
		        }
		    }
		    
		    if ($q5>0){
		        if ($q4>0)
		        {
		          $sWhere .=" and analista_solicitudes ='$q5'";
		          $sWhere1 .=" and analista_solicitudes ='$q5'";    
		        }
		        else
		        {
		            $sWhere .=" analista_solicitudes ='$q5'";
		            $sWhere1 .=" analista_solicitudes ='$q5'";
		        }
		    }
           
           ///////////////
           
          

		    // Configurar el modo de error para excepciones
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $sWhere.=" order by registro desc";
		    $sWhere1.=" group by registro ";
		    include 'pagination.php'; //include pagination file
		    //paginación variables
		    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		    $per_page = 10; //cuantos registros desea mostrar
		    $adjacents  = 4; //gap entre paginas despues del número de adyacentes
		    $offset = ($page - 1) * $per_page;
		
	        // Consulta SQL para contar las filas
            $sql = "SELECT COUNT(*) AS total_filas FROM $sTable $sWhere1";
            $sql1 = "SELECT COUNT(*) AS total_filas FROM $sTable $sWhere1";
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
				    <th>No.Registro</th>
					<th>Fecha UNP</th>
					<th>Fecha GRAERR</th>
					<th>Documento</th>
					<th COLSPAN="2">Peticionario</th> 
					<th>Estado</th>
					<th class='text-center' colspan="4">Acciones</th>
        <?php    
                    $sql="SELECT * FROM  $sTable $sWhere OFFSET $offset LIMIT $per_page";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $registro=$row['registro'];
						$fecha_recepcion_unp=$row['fecha_recepcion_unp'];
						$fecha_recepcion_graerr=$row['fecha_recepcion_graerr'];
						$no_documento=$row['no_documento'];
						$nombres_peticionario=$row['nombres_peticionario'];
						$apellidos_peticionario=$row['apellidos_peticionario'];
						$estado_solicitud=$row['estado_solicitud'];
						 
						
						//trae estado solicitud
						$sqlSol    = "select * from graerr_estado_solicitud where id=$estado_solicitud";
						$stmtSol   = $pdo->query($sqlSol);
					    $rowSol    = $stmtSol->fetch(PDO::FETCH_ASSOC);
					    $solicitud = $rowSol['estado_solicitud'];
						
 					    $lv   = $registro. "/MOD1234567890qwertyuiopasdfghjkl";
					    $lVDX = base64_encode($lv);
        ?>
                        <tr>	
  		   			      <td><?php echo $registro; ?></td>
  					       <td><?php echo $fecha_recepcion_unp; ?></td>
  					       <td><?php echo $fecha_recepcion_graerr; ?></td>
  					       <td><?php echo number_format($no_documento); ?></td>
  					       <td><?php echo $nombres_peticionario; ?></td>
  					       <td><?php echo $apellidos_peticionario; ?></td>
  					       <td><?php echo $solicitud; ?></td>
 
					       <td class='text-center'>
					         <a href="graerrFormulario1.php?LA=<?=$lVDX?>" class='btn btn-default' title='Editar registro' ><i class="glyphicon glyphicon-edit"></i></a> 
					       </td>  
					   </tr>
        <?php
                    }//while
        ?>
                       <tr>
					      <td colspan="10">
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
 	
 	