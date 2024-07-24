<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	
   	
 	try {
 	    // Crear una nueva instancia de conexión PDO
        $pdo = new PDO($dsn);
        $sTable = "reu_reuniones";
        
        echo '<br>';
        echo "entra 1..";
        echo '<br>';
        
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
            $q = strip_tags($_REQUEST['q']);
            $q = htmlentities($q, ENT_QUOTES, 'UTF-8');
            $q1 = strip_tags($_REQUEST['q1']);
            $q1 = htmlentities($q, ENT_QUOTES, 'UTF-8');
            $q2 = strip_tags($_REQUEST['q2']);
            $q2 = htmlentities($q, ENT_QUOTES, 'UTF-8');
            $q3 = strip_tags($_REQUEST['q3']);
            $q3 = htmlentities($q, ENT_QUOTES, 'UTF-8');
             
             echo '<br>';
             echo "q: " . $q;
             echo '<br>';
             echo "q1: " . $q1;
             echo '<br>';
             echo "q2: " . $q2;
             echo '<br>';
             echo "q3: " . $q3;
             echo '<br>';
             echo "q4: " . $q4;
             echo '<br>';
                  
            
            //$q = strtoupper($q);
            $q1 = strtoupper($q1);
            $q2 = strtoupper($q2);
            $q3 = strtoupper($q3);
            
            
            if ($q!="")
            {
              $aColumns = array('fechareunion');//Columnas de busqueda
            }
            else
            {
             $aColumns = "";
            }
            
            $sTable = "reu_reuniones";
		    $sWhere = "";
		   
		    /*
		    $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
				//$sWhere .= $aColumns[$i]." = ".$q." OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
			*/
		
		  	if ($q!=""){
		        $sWhere .=" fechareunion ='$q'";
		        $sWhere1 .=" fechareunion ='$q'";
		    }
		    
		  	if ($q1>0){
		        $sWhere .=" and convocadapor ='$q1'";
		    }
		    if ($q2>0){
		        $sWhere .=" and iddependencia ='$q2'";
		    }
		    if ($q3>0){
		        $sWhere .=" and idgrupo ='$q3'";
		    }
           
		    // Configurar el modo de error para excepciones
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $sWhere.=" order by fechareunion desc";
		    $sWhere1.=" group by fechareunion ";
		    include 'pagination.php'; //include pagination file
		    //paginación variables
		    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		    $per_page = 10; //cuantos registros desea mostrar
		    $adjacents  = 4; //gap entre paginas despues del número de adyacentes
		    $offset = ($page - 1) * $per_page;
		
	        // Consulta SQL para contar las filas
            $sql = "SELECT COUNT(*) AS total_filas FROM $sTable $sWhere";
            echo '<br>';
            echo "sql cts..en sql.." . $sql;
            echo '<br>';
            
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
				    <th>No.Reunion</th>
					<th>Fecha</th>
					<th>Convocada por</th>
					<th>Dependencia</th>
					<!--<th>Grupo</th>-->
					<th>Estado</th>
					<th class='text-center' colspan="3">Acciones</th>
        <?php    
                    $sql="SELECT * FROM  $sTable $sWhere OFFSET $offset LIMIT $per_page";
                    echo '<br>';
                    echo "sql cpnsulta..." . $sql;
                    echo '<br>';
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $idReunion=$row['idreunion'];
						$fechaReunion=$row['fechareunion'];
						$convocadaPor=$row['convocadapor'];
						$idDependencia=$row['iddependencia'];
						$idGrupo=$row['idgrupo'];
						$detalleReunion=$row['detallereunion'];
						$estadoReunion=$row['estadoreunion'];
						$entidad=$row['identidad'];
						$dependencia=$row['iddependencia'];
						$idGrupo=$row['idgrupo'];
						
						//trae persona
						$sqlPer   = "select * from reu_participante where numeroidparticipante=$convocadaPor";
						$stmtPer = $pdo->query($sqlPer);
					    $rowPer  = $stmtPer->fetch(PDO::FETCH_ASSOC);
					    $persona     = $rowPer['nombresparticipante'];
						
			            //trae entidad
					    $sqlEnt  ="select * from reu_entidades where identidad=$entidad";
					    ECHO '<BR>';
					    echo $sqlEnt;
					    ECHO '<BR>';
					    $stmtEnt = $pdo->query($sqlEnt);
					    $rowEnt  = $stmtEnt->fetch(PDO::FETCH_ASSOC);
					    $ent     = $rowEnt['nombreentidad'];
					    
					    //trae dependencia
					    $sqlDep  ="select * from reu_dependencias where iddependencia=$dependencia";
					    $stmtDep = $pdo->query($sqlDep);
					    $rowDep  = $stmtDep->fetch(PDO::FETCH_ASSOC);
    				    $depen     = $rowDep['nombredependencia'];
    				    
    				    //trae grupo
					    $sqlGrupo  ="select * from reu_grupos_internos where idgrupoInterno=$idGrupo";
					    $stmtGrupo = $pdo->query($sqlGrupo);
					    $rowGrupo  = $stmtGrupo->fetch(PDO::FETCH_ASSOC);
    				    $grupo  = $rowGrupo['grupoInterno']; 
 
 					    $lv   = $idReunion. "/MOD1234567890qwertyuiopasdfghjkl";
					    $lVDX = base64_encode($lv);
        ?>
                        <tr>	
  		   			      <td><?php echo $idReunion; ?></td>
  					       <td><?php echo $fechaReunion; ?></td>
  					       <td><?php echo $persona; ?></td>
  					       <td><?php echo $depen; ?></td>
  					       <!--<td><?php echo $grupo; ?></td>
  					       <td><?php echo $detalleReunion; ?></td>-->
  					       <td><?php echo $estadoReunion; ?></td>
 
					       <td class='text-center'>
					         <a href="reu1?LA=<?=$lVDX?>" class='btn btn-default' title='Editar reunión' ><i class="glyphicon glyphicon-edit"></i></a> 
					       </td>  
					       <td class='text-center'>  
					         <a href="reuI.php?LA=<?=$lVDX?>" class='btn btn-default' title='Imprimir acta' ><i class="glyphicon glyphicon-print"></i></a> 
					        </td>
					        <td class='text-center'>  
					         <a href="#" class='btn btn-default'title='Borrar reunión' onclick="eliminar('<?php echo $idReunion; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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
 	
 	