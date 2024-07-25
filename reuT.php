<?php
 
  session_start();
  /*
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
  {
    header("location: login.php");
    exit;
  }
  */
  $active_marca="active";  
  $title="UNP | Reuniones";    
  $nombreUsuario = $_SESSION['user_firstname'] ." " .$_SESSION['user_lastname']; 
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
 
  <script>
   function eliminarTarea()
   {
    if(confirm('¿Estas seguro de eliminar la tarea?'))
      return true;
    else
    return false;
   }
   
   function confirmarTarea()
   {
    if(confirm('¿Estas seguro de dar por terminada la tarea?'))  
      return true;
    else
    return false;
   }
  </script>
  
  
 <?php
   include("navbar.php");
   // Crear una nueva instancia de conexión PDO
   $pdo = new PDO($dsn);
   
   echo '<br>';
   echo "aqui...";
   echo '<br>';
    $s_LA    = $_GET['LA'];
    $linDeco = base64_decode($s_LA);
    
    //PARTE LA LINEA
    $partir      = explode ("/", $linDeco);   
    
    $s_idReunion            = $partir[0];
    $s_numeroIdParticipante = $partir[1];
    $s_idCompromiso         = $partir[2];
    $tipAccion              = $partir[3];  
    
    
    if(isset($_POST['grabar']))
    {   
      $s_idReunion            = $_POST['idReunion'];
      $s_numeroIdParticipante = $_POST['numeroIdParticipante']; 
      $s_idCompromiso         = $_POST['idCompromiso']; 
      $s_tareaRealizada       = $_POST['tareaRealizada'];
      
      ECHO "grabar..";
      ECHO '<BR>';
      
      echo "1. " . $s_idReunion;
      ECHO '<BR>';
      echo "2. " . $s_numeroIdParticipante; 
      ECHO '<BR>';
      echo "3. " . $s_idCompromiso; 
      ECHO '<BR>';
      echo "4. " . $s_tareaRealizada;
      ECHO '<BR>';
      
      
      date_default_timezone_set('America/Bogota');
      //$s_fecha  = date("Y-m-d",time());
      //$s_fecha  = date("Y/m/d H:i:s");
      $date_added=date("Y-m-d");
      
      $s_existe         = $_POST['existe'];
      $s_yaGrabo        = $_POST['yaGrabo'];
      
      $sql = "select max(idtarea) as maximo from reu_tareas_realizadas ";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      $s_maximo  = $row['maximo'];
      $s_idTarea = $s_maximo+1;
      
      $sql="INSERT INTO reu_tareas_realizadas (idtarea, idreunion, numeroidparticipante, idcompromiso, tarearealizada, fechatarea) 
                    VALUES (?, ?, ?, ?, ?, ?)";
                     echo "insert.." . $sql;
       echo $sql;
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$s_idTarea , $s_idReunion, $s_numeroIdParticipante, $s_idCompromiso, $s_tareaRealizada, $date_added]);
      
      $mensaje=" <b>Atención!</b> Grabación exitosa";
      
      $s_existe ="1";
      $s_tocoBoton = "S";
    }  
    
    
    $sql_par  = "SELECT * FROM reu_participante where numeroidparticipante=$s_numeroIdParticipante";
    $stmt_par = $pdo->query($sql_par);
    $row_par  = $stmt_par->fetch(PDO::FETCH_ASSOC);
    $nombre   = $row_par['nombresparticipante']; 
    
	$sqlCompromiso ="select * from reu_compromisos where idreunion=$s_idReunion and numeroidparticipante=$s_numeroIdParticipante and idcompromiso=$s_idCompromiso";
    $stmt_com = $pdo->query($sqlCompromiso);
    $row_com  = $stmt_com->fetch(PDO::FETCH_ASSOC);
    $compromiso   = $row_com['compromisoadquirido']; 
    
    
    echo "1.." . $s_idReunion;
    echo '<br>';
    echo "2.." . $s_numeroIdParticipante;
    echo '<br>';
    echo "3.." . $s_idCompromiso;
    echo '<br>';
     
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
    
?>
            <!-- Page Content Holder -->
            <div id="content">  
                  <!--- MENU CERRAR ---->
                     <nav class="navbar navbar-default">  
                         <div class="container-fluid" style="background-color:#fff;">
                             <div class="navbar-header">
                                 <img src="img/usuario_ap.svg" class="img-circle" alt="Cinque Terre" width=40px; > 
                                 <span style="color:#002857; font-size:1.3em; font-weight:600; "><?=$nombreUsuario?> </span>  
                                 <p style="color:grey; font-size:14px; font-family:snas-serif:">Fecha de último ingreso: </p>
                             </div>
                          </div>
                    <!-- </nav>  ---->
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
                         <a href="reu1.php?LA=<?=$lVDX?>" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
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
    			   <td colspan="6" align="center">TAREAS DE: <b><?=$compromiso?></b></td>
    			 </tr>
    			 <tr class="info">
    			     <th>No.Tarea</th>
					 <th>Fecha Tarea</th>
					 <th>Actividad Realizada</th>
					 <th>Tarea Terminada?</th>
					 <th>Terminar Tarea</th>
					 <th>Borrar Tarea</th>
				 </tr>   
				 
            	 <?php  
            	    if ($s_tocoBoton=="S")
               	    {
                       $sql="select * from reu_tareas_realizadas where idreunion=$s_idReunion and numeroidparticipante=$s_numeroIdParticipante and idcompromiso=$s_idCompromiso";
                       $stmt = $pdo->query($sql);
                       
                       $i=1;
			           while ($rowCompromiso  = $stmt->fetch(PDO::FETCH_ASSOC)){
                           $idTarea= $rowCompromiso['idtarea'];
    			      	   $idReunion= $rowCompromiso['idreunion'];
    			      	   $idCompromiso= $rowCompromiso['idcompromiso'];
    			      	   $tareaRealizada= $rowCompromiso['tarearealizada'];
    			      	   $terminada= $rowCompromiso['terminada'];
    			      	   $fechaTarea= $rowCompromiso['fechatarea'];
    			      	     
    			      	   if ($terminada=='S')
    			      	   {
    			      	       $seTermino="Si";
    			      	   }
    			      	   else
    			      	   {
    			      	       $seTermino="No";
    			      	   }
    			      	   
    			      	   $borrarTarea=$s_idReunion."-".$s_numeroIdParticipante."-".$s_idCompromiso ."-" .$idTarea;
    			      	   
                  ?> 
                         <tr>	
  					       <td><?php echo $idTarea; ?></td>
  					       <td><?php echo $fechaTarea; ?></td>
  					       <td><?php echo $tareaRealizada; ?></td>
  					       <td align="center"><?php echo $seTermino; ?></td>
  				 	       <td class='text-center'>
  					        <input class='btn btn-success btn-sm' type='submit' id='terminarTarea' name='terminarTarea' value='<?=$borrarTarea?> '  style='width:40' onclick='return confirmarTarea()'>  <i class="fa fa-check" aria-hidden="true"></i>  
					       </td>
					       <?php
					        echo "ter.." . $terminada;
					         if ($terminada!='S')
    			  	         {
    			  	       ?>  
					         <td class='text-center'>
  					          <input class='btn btn-danger btn-sm' type='submit' id='borrarTarea' name='borrarTarea' value='<?=$borrarTarea?> '  style='width:40' onclick='return eliminarTarea()'>  <i class="fa fa-trash" aria-hidden="true"></i>  
					         </td>
					       <?php
    			  	         }
    			  	       ?>  
				         </tr> 
                  <?php 
    			      	}//while
               	     }
                  ?>
              </table>
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
 