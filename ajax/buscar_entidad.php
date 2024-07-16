<?php
 	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
 	 
	if (isset($_GET['id'])){
		
		$id_identidad=intval($_GET['id']);
		/*
		$query=mysqli_query($con, "select * from reu_reuniones where identidad='".$id_identidad."'");
		$count=mysqli_num_rows($query);
		
		$sql = "SELECT * FROM reu_reuniones WHERE identidad = $id_identidad";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_identidad', $id_identidad, PDO::PARAM_INT);
        $stmt->execute();

        // Contar el número de filas obtenidas
        $count = $stmt->rowCount();
        */
        echo "cuantos.." . $count; 

		if ($count==0){
		    $borrar="DELETE FROM reu_entidades  WHERE identidad='".$id_identidad."'";
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
			  <strong>Error!</strong> No se pudo eliminar ésta entidad. Existen registros vinculados a ésta entidad. 
			</div>
			<?php
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
		/*
		 $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombreentidad');//Columnas de busqueda
		 $sTable = "reu_entidades";
		 $sWhere = "";
		
		// Limpiar y obtener el valor de 'q' de la solicitud ($_REQUEST)
        $q = strip_tags($_REQUEST['q'], ENT_QUOTES);
        
        // consulta preparada con PDO
        $sql = "SELECT * FROM $sTable WHERE columna = :q";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':q', $q, PDO::PARAM_STR);
        $stmt->execute();

        // Obtener resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Iterar sobre los resultados (ejemplo)
        foreach ($resultados as $fila) {
            // Procesar cada fila
            echo $fila['nombreentidad'];
            echo '<br>';
        }
 
           $sWhere = "";
		    $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		*/
		   	
		 
		$sWhere.=" order by nombreentidad";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		// Crear una nueva instancia de conexión PDO
        $pdo = new PDO($dsn);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql="SELECT COUNT(*) AS cuantos FROM reu_entidades";
		echo '<br>';
		echo "el sql ..". $sql;
		echo '<br>';
		$count_query = $pdo->query($sql);
		$row = $count_query->fetch(PDO::FETCH_ASSOC);
		$numrows = $row['cuantos'];
		echo '<br>';
		echo "num_rows.." .  $numrows;
		echo '<br>';
		// Calcular el total de páginas
        $total_pages = ceil($numrows / $per_page);
        $reload = './marcas.php';
		
		/*
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './marcas.php';
		*/
		
		
		$stmt = $pdo->query('SELECT * FROM reu_categorias');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Nombre: {$row['des_categoriareunion']}<br />";
    }
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
	    echo "sql..." . $sql;
	    echo '<br>';
	    $stmt = $pdo->query($sql);
	    
		//$query = mysqli_query($con, $sql);
		//loop through fetched data
		
		if ($numrows>0){
			
			?>
			<div class="table-responsive">

			  <table class='tablaResponsive table table-striped table-bordered table-hover'>
				<tr  class="info">
					<th>Entidad</th>
					<th class='text-center'>Acciones</th>
				</tr>
				<?php
				//while ($row=mysqli_fetch_array($query)){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "Nombre: {$row['nombreentidad']}<br />";   
						$idEntidad=$row['identidad'];
						$nombreEntidad=$row['nombreentidad'];
						 
 					    $lv   = $idEntidad. "/MOD1234567890qwertyuiopasdfghjkl";
					    $lVDX = base64_encode($lv);
					?>
					<tr>	
  					   <td><?php echo $nombreEntidad; ?></td>
					   
					   <td class='text-center'>
					     <a href="entidad1?LA=<?=$lVDX?>" class='btn btn-default' title='Editar entidad' ><i class="glyphicon glyphicon-edit"></i></a> 
					     <a href="#" class='btn btn-default' title='Borrar grupo' onclick="eliminar('<?php echo $idEntidad; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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