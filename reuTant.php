<?php
 
  session_start();
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
  {
    header("location: login.php");
    exit;
  }
  
  $active_marca="active";  
  $title="UNP | Reuniones";    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
 <?php 
     require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
     require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
     include("head.php");
  ?>
  </head>
  
 <?php
   include("navbar.php");
   
    $s_LA    = $_GET['LA'];
    $linDeco = base64_decode($s_LA);
   
    //PARTE LA LINEA
    $partir      = explode ("/", $linDeco);   
    
    $s_idReunion            = $partir[0];
    $s_numeroIdParticipante = $partir[1];
    $s_idCompromiso         = $partir[2];
    $tipAccion              = $partir[3];  
    
    $sql_par  = "SELECT * FROM reu_participante where numeroIdParticipante=$s_numeroIdParticipante";
	$query_par = mysqli_query($con, $sql_par);
    $row_par  = mysqli_fetch_array($query_par);
	$nombre   = $row_par['nombresParticipante']; 
	
	$sqlCompromiso ="select * from reu_compromisos where idReunion=$s_idReunion and numeroIdParticipante=$s_numeroIdParticipante and idCompromiso=$s_idCompromiso";
    $queryCompromiso = mysqli_query($con, $sqlCompromiso); 
    $rowCompromiso=mysqli_fetch_array($queryCompromiso);
    $compromiso  = $rowCompromiso['compromisoAdquirido'];  
    
    /*
    echo "1.." . $s_idReunion;
    echo '<br>';
    echo "2.." . $s_numeroIdParticipante;
    echo '<br>';
    echo "3.." . $s_idCompromiso;
    echo '<br>';
    */
    if ( $s_idReunion != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "MODIFICAR TAREA";
      $s_existe = 1;
      $boton  = "Actualizar";
      $s_tocoBoton="S";
    }
    else
    {
      $titulo = "NUEVA TAREA";
      $s_existe = 0;
      $boton="Grabar";
    }  
    
    if(isset($_POST['grabar']))
    {   
      $s_idReunion            = $_POST['idReunion'];
      $s_numeroIdParticipante = $_POST['numeroIdParticipante']; 
      $s_idCompromiso         = $_POST['idCompromiso']; 
      $s_tareaRealizada       = $_POST['tareaRealizada'];
      
      date_default_timezone_set('America/Bogota');
      //$s_fecha  = date("Y-m-d",time());
      //$s_fecha  = date("Y/m/d H:i:s");
      $date_added=date("Y-m-d");
      
      $s_existe         = $_POST['existe'];
      $s_yaGrabo        = $_POST['yaGrabo'];
      
      $sql1 = "select max(idTarea) as maximo from reu_tareas_realizadas ";
      $query1 = mysqli_query($con, $sql1);  
      $row1=mysqli_fetch_array($query1);
      $s_idTarea     = $row1[maximo]+1;
      
      $sql="INSERT INTO reu_tareas_realizadas (idTarea, idReunion, numeroIdParticipante, idCompromiso, tareaRealizada, fechaTarea) 
                                  VALUES ('$s_idTarea', '$s_idReunion', '$s_numeroIdParticipante', '$s_idCompromiso', '$s_tareaRealizada', '$date_added')";
      echo $sql;
      
      $query_new_insert = mysqli_query($con,$sql);
      $mensaje=" <b>Atención!</b> Grabación exitosa";
      
      $s_existe ="1";
      $s_tocoBoton = "S";
      
    }  
 ?>    
            <!-- Page Content Holder -->
            <div id="content">  
                  <!--- MENU CERRAR ---->
                  <nav class="navbar navbar-default">
                      <div class="container-fluid">
                          <div class="navbar-header">
                              <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                  <i class="fas fa-arrows-alt-h"></i>
                                  <span>Menú/span>                                
                              </button>              
                          </div>
                       </div>
                  </nav>
                  <!--- FIN MENU CERRAR ---->
                  
                  <!--- BARRA DE TITULO ---->
                  <div class="fondo"> 
                      <div class="row">
                       <div class="col-sm-6" ALIGN="left">
                          <h3> <i class='fas fa-cogs' style='color:#2f79b9'></i> COMPROMISOS </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <?php
                          $lv   = $s_idReunion. "/MOD1234567890qwertyuiopasdfghjkl";
					      $lVDX = base64_encode($lv);
                         ?>
                         <a href="reu1?LA=<?=$lVDX?>" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
                        </div>                
                      </div>
                  </div>
                  <!--- FIN BARRA DE TITULO ----> 
                  
                  <div class="panel panel-info">
                 <div class="panel-heading">
                <div class="btn-group pull-right">        	     
                </div>
              <h4><i class="fas fa-user" style='color:#2f79b9'></i> <?=$nombre?>  </h4>
            </div>
      
            <?php  
              if ($s_tocoBoton=="S")
              {
            ?> 
                <div class="alert alert-success" align="center"><?=$mensaje?></div>
            <?php 
              }
            ?>
            
            <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">			 
                <div class="panel-body">
                    <div class="row">
                       <div class=" col-md-12 col-lg-12 "> 
			              <table class="table table-condensed">
                               <tbody>
                                   <div class="form-group row">
         		                      <div class='col-md-12'><br>  
         		                         <label>Tarea realizada para el compromiso:</label>
          		                         <?php echo $compromiso; ?>
         		                         <textarea id="tareaRealizada" name="tareaRealizada" rows="2" class="form-control" ><?php echo $s_tareaRealizada; ?></textarea>
         		                      </div>    
         		                   </div>
                               </tbody>
                               
                                <div class="modal-footer"> 
                                   <div class="col-sm-12" align="right">  					  			 
                                     <button type="submit" name='grabar' class="btn btn-block btn-success"><i class="fas fa-plus"></i> Agregar Tarea </button>
                                   </div>
                                </div>   
			              </table>			
		               </div>        	      
        	        </div> <!--row-->     
                </div>
             <div style="display:none;">
               <input style="visibility:hidden" name="idReunion" id="idReunion" value="<?=$s_idReunion?>"/>
               <input style="visibility:hidden" name="numeroIdParticipante" id="numeroIdParticipante" value="<?=$s_numeroIdParticipante?>"/>
               <input style="visibility:hidden" name="idCompromiso" id="idCompromiso" value="<?=$s_idCompromiso?>"/>
               <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
               <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
             </div>      
            </form>    
            
            <table class='tablaResponsive table table-striped table-bordered table-hover'>
               <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SE LF']; ?>">
    			 <tr> 
    			   <td colspan="6" align="center">TAREAS DE: <b><?=$nombre?></b></td>
    			 </tr>
    			 <tr class="info">
    			     <th>No.Tarea</th>
					 <th>Fecha Tarea</th>
					 <th>Tarea Realizada</th>
					 <th class='text-center'>Acciones</th>
				 </tr>   
				 
            	 <?php  
            	    if ($s_tocoBoton=="S")
               	    {
                     	 $sqlCompromiso ="select * from reu_tareas_realizadas where idReunion=$s_idReunion and numeroIdParticipante=$s_numeroIdParticipante and idCompromiso=$s_idCompromiso";
                     	 echo $sqlCompromiso;
    			  	     $queryCompromiso = mysqli_query($con, $sqlCompromiso); 
    			  	     while ($rowCompromiso=mysqli_fetch_array($queryCompromiso)){
    			     	   $idTarea= $rowCompromiso['idTarea'];
    			      	   $idReunion= $rowCompromiso['idReunion'];
    			      	   $idCompromiso= $rowCompromiso['idCompromiso'];
    			      	   $tareaRealizada= $rowCompromiso['tareaRealizada'];
    			      	   $fechaTarea= $rowCompromiso['fechaTarea'];
    			      	     
    			      	   $borrarTarea=$s_idReunion."-".$numeroIdParticipante."-".$idCompromiso."-".$idTarea;
                  ?> 
                         <tr>	
  					       <td><?php echo $idTarea; ?></td>
  					       <td><?php echo $fechaTarea; ?></td>
  					       <td><?php echo $tareaRealizada; ?></td>
  				 	       <td class='text-center'>
  					        <input class='btn btn-danger btn-sm' type='submit' id='borrarTarea' name='borrarTarea' value='<?=$borrarTarea?> '  style='width:40' onclick='return confirmarTarea()'>  <i class="fa fa-trash" aria-hidden="true"></i>  
					       </td>
				         </tr> 
                  <?php 
    			      	}//while
               	     }
                  ?>
             
        </div> <!-- content -->   
       
       <!--- complemento -->
        <?php
           include("complemento.html");             
        ?>
        <!--- fin complemento -->
             
    <hr>
     <?php
      // include("footer.php");
     ?>
      
      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="js/jasny-bootstrap.min.js"></script>
    
  
    </body>
  </html>
 