<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	
	if (isset($_GET['id'])){
		$id_participante=intval($_GET['id']);
		$query=mysqli_query($con, "select * from reu_reuniones where numeroIdParticipante='".$id_participante."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
		    $borrar="DELETE FROM reu_participante WHERE numeroIdParticipante='".$id_participante."'";
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
			  <strong>Error!</strong> No se pudo eliminar éste participante. Existen registros vinculados a ésta participante. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        //$disenador =intval($_REQUEST['id_disenador']); 
                 
		 $aColumns = array('numeroIdParticipante', 'nombresParticipante');//Columnas de busqueda
		 $sTable = "reu_participante";
		 $sWhere = "";
		 
		    $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		
		  //if ($disenador>0){
		  //    $sWhere .=" and idDisenador='$disenador'";
		  // }	
		 
		$sWhere.=" order by nombresParticipante";
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
				 while ($row=mysqli_fetch_array($query)){
					$numeroIdParticipante=$row['numeroIdParticipante'];
  					$nombresParticipante=$row['nombresParticipante'];
  					$celularParticipante=$row['celularParticipante'];
  					$correoParticipante=$row['correoParticipante'];
  					$departamento=$row['departamento'];
  					$ciudad=$row['ciudad'];
  					$entidad=$row['entidad'];
  					$dependencia=$row['dependencia'];
  					$cargo=$row['cargo'];
					
					$lv   = $numeroIdParticipante. "/MOD1234567890qwertyuiopasdfghjkl";
					$lVDX = base64_encode($lv);
					
					//trae entidad
					$sqlEnt="select * from reu_entidades where idEntidad='$entidad'";
					$queryEnt    = mysqli_query($con, $sqlEnt); 
    				$lineEnt     = mysqli_fetch_array($queryEnt);
    				$ent         = $lineEnt['nombreEntidad'];
     				
					//trae dependencia
					$sqlDep ="select * from reu_dependencias where idDependencia='$dependencia'";
					$queryDep    = mysqli_query($con, $sqlDep); 
    				$lineDep     = mysqli_fetch_array($queryDep);
    				$dep         = $lineDep['nombreDependencia'];
    				
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
					     <a href="participante1?LA=<?=$lVDX?>" class='btn btn-default' title='Editar participante' ><i class="glyphicon glyphicon-edit"></i></a> 
					     <a href="#" class='btn btn-default' title='Borrar participante' onclick="eliminar('<?php echo $numeroIdParticipante; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					    </td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="8"><span class="pull-right">
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