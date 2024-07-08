<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	
 
 	
	if (isset($_GET['id'])){
		$id_grupo=intval($_GET['id']);
		$query=mysqli_query($con, "select * from reu_reuniones where idGrupo='".$id_grupo."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
		    $borrar="DELETE FROM reu_grupos_internos  WHERE idGrupoInterno='".$id_grupo."'";
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
			  <strong>Error!</strong> No se pudo eliminar éste grupo. Existen registros vinculados a ésta grupo. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        //$disenador =intval($_REQUEST['id_disenador']); 
                 
		 $aColumns = array('grupoInterno');//Columnas de busqueda
		 $sTable = "reu_grupos_internos";
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
		 
		$sWhere.=" order by grupoInterno";
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
					<th>Grupo Interno</th>
					<th class='text-center'>Acciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$idGrupoInterno=$row['idGrupoInterno'];
						$grupoInterno=$row['grupoInterno'];
						 
 					    $lv   = $idGrupoInterno. "/MOD1234567890qwertyuiopasdfghjkl";
					    $lVDX = base64_encode($lv);
						
					?>
					<tr>	
  					   <td><?php echo $grupoInterno; ?></td>
					   
					   <td class='text-center'>
					     <a href="grupos1?LA=<?=$lVDX?>" class='btn btn-default' title='Editar zona' ><i class="glyphicon glyphicon-edit"></i></a> 
					     <a href="#" class='btn btn-default' title='Borrar grupo' onclick="eliminar('<?php echo $idGrupoInterno; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					    </td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="2"><span class="pull-right">
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