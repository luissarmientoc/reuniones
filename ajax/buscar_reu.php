<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	
	if (isset($_GET['id'])){
		$id_reunion=intval($_GET['id']);
		$sql="select * from reu_reuniones_participante where idReunion=$id_reunion";
 		$query=mysqli_query($con, $sql);
		$count=mysqli_num_rows($query);
		if ($count==0){
 		    $borrar="DELETE FROM reu_reuniones  WHERE idReunion='".$id_reunion."'";
		    //echo $borrar;
			if ($delete1=mysqli_query($con,$borrar)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Atención!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar ésta reunión. Existen participantes vinculados a la reunión. 
			</div>
			<?php
		}
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q  = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
         $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
         $q3 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q3'], ENT_QUOTES)));
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
        echo "q4: " . $q4;
        echo '<br>';
        */      
		 $aColumns = array('idReunion');//Columnas de busqueda
		 $sTable = "reu_reuniones";
		 $sWhere = "";
		 
		    $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		
		  	if ($q1>0){
		        $sWhere .=" and convocadaPor ='$q1'";
		    }
		    if ($q2>0){
		        $sWhere .=" and idDependencia ='$q2'";
		    }
		    if ($q3>0){
		        $sWhere .=" and idGrupo ='$q3'";
		    }
		 
		$sWhere.=" order by idReunion";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './marcas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
	    //echo "sql..." . $sql;
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">

			  <table class='tablaResponsive table table-striped table-bordered table-hover'>
				<tr  class="info">
					<th>No.Reunion</th>
					<th>Fecha</th>
					<th>Convocada por</th>
					<th>Dependencia</th>
					<!--<th>Grupo</th>-->
					<th>Estado</th>
					<th class='text-center' colspan="3">Acciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$idReunion=$row['idReunion'];
						$fechaReunion=$row['fechaReunion'];
						$convocadaPor=$row['convocadaPor'];
						$idDependencia=$row['idDependencia'];
						$idGrupo=$row['idGrupo'];
						$detalleReunion=$row['detalleReunion'];
						$estadoReunion=$row['estadoReunion'];
						
						$sqlPer   = "select * from reu_participante where numeroIdParticipante=$convocadaPor";
						$queryPer = mysqli_query($con, $sqlPer);  
						$rowPer   = mysqli_fetch_array($queryPer);
			            $persona  = $rowPer['nombresParticipante'];  
			            
						$sqlDepen    = "select * from reu_dependencias where idDependencia=$idDependencia";
						$queryDepen  = mysqli_query($con, $sqlDepen);  
						$rowDepen    = mysqli_fetch_array($queryDepen);
			            $depen       = $rowDepen['nombreDependencia'];  
						
						$sqlGrupo    = "select * from reu_grupos_internos where idGrupoInterno=$idGrupo";
						$queryGrupo  = mysqli_query($con, $sqlGrupo);
						$rowGrupo    = mysqli_fetch_array($queryGrupo);
			            $grupo       = $rowGrupo['grupoInterno']; 
 
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
				}
				?>
				<tr>
					<td colspan="10"><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>