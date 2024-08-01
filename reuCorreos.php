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
  
  <?php  
   include("navbar.php");
    // Crear una nueva instancia de conexión PDO
    $pdo = new PDO($dsn);
   
    $s_LA    = $_GET['LA'];
    $linDeco = base64_decode($s_LA);
   
    //PARTE LA LINEA
    $partir      = explode ("/", $linDeco);   
    
    $s_idReunion   = $partir[0];
    $tipAccion     = $partir[1];
    
    
    if(isset($_POST['enviarcorreo']))
    {
      $s_idReunion    = $_POST['idReunion']; 
      $s_yaGrabo      = $_POST['yaGrabo'];
      $s_existe       = $_POST['existe']; 
        
      $sql = "select * from reu_reuniones where idreunion=$s_idReunion";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
    
      $s_idReunion         = $row['idreunion'];
      $s_fechaReunion      = $row['fechareunion'];
      $s_horaReunion       = $row['horareunion'];
      $s_lugarReunion      = $row['lugarreunion'];
      $s_convocadaPor      = $row['convocadapor'];
      $s_idEntidad         = $row['identidad'];
      $s_idDependencia     = $row['iddependencia'];
      $s_idGrupo           = $row['idgrupo'];
      $s_idCategoria       = $row['idcategoria'];
      $s_idSubCategoria    = $row['idsubcategoria'];
      $s_detalleReunion    = $row['detallereunion'];
      $s_desarrolloReunion = $row['desarrolloreunion'];
      $s_estadoReunion     = $row['estadoreunion'];
      $s_fechaEstado       = $row['fechaestado'];
      
      //TOMA EL CORREO DE QUIEN CONVOCA
      $sqlConvoca      = "select * from reu_participante where numeroidparticipante=$s_convocadaPor";
	  $stmtConvoca     = $pdo->query($sqlConvoca);
	  $rowConvoca      = $stmtConvoca->fetch(PDO::FETCH_ASSOC);
	  $personaConvoca  = $rowConvoca['nombresparticipante'];
	  $correoConvoca   = $rowConvoca['correoparticipante'];
	  $celularConvoca  = $rowConvoca['celularparticipante'];
      
      //TOMA EL LUGAR DE LA REUNION
      $sqlLugar  = "select * from reu_lugares where idlugar = $s_lugarReunion";
      $stmtLugar = $pdo->query($sqlLugar);
      $rowLugar  = $stmtLugar->fetch(PDO::FETCH_ASSOC);
      $lugar     = $rowLugar['nombrelugar'];
      
      //TOMA EL CORREO Y LOS DATOS DE LOS PARTICPANTES
      $sql="select * from  reu_reuniones_participante where idreunion = $s_idReunion";
      $stmt = $pdo->query($sql);
      $enviarA='';
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $numeroIdParticipante=$row['numeroidparticipante'];
      
            //trae persona
			$sqlPer    = "select * from reu_participante where numeroidparticipante=$numeroIdParticipante";
			$stmtPer   = $pdo->query($sqlPer);
			$rowPer    = $stmtPer->fetch(PDO::FETCH_ASSOC);
			$persona   = $rowPer['nombresparticipante'];
			$correoPar = $rowPer['correoparticipante'];
			$celularPar= $rowPer['celularparticipante'];
			
			$enviarA =  $enviarA . $correoPar .", " ;
      }					    
      
      //TOMA EL LUGAR DE REUNION
      
      //ARMA EL CUERPO DEL CORRERO
      $elAsunto = "Invitación a reunión de: " . $s_detalleReunion;
      $mensaje =  "<b>Id de la reunión: </b>" . $s_idReunion ."\n" .
                  "<b>Tema:</b> " . $s_detalleReunion . "\n" .
                  "<b>Fecha:</b> " . $s_fechaReunion . "<b>Hora: </b>". $s_horaReunion ."\n";
                  "<b>Lugar:</b> " .  $lugar ."\n"; 
                  
      /*
      echo '<br>';
      echo "Asunto.. " . $elAsunto;
      echo '<br>';
      echo "Enviar a.. " . $enviarA;
      echo '<br>';
      echo "Enviado por.. ". $correoConvoca;
      echo '<br>';
      echo "Mensaje.. " . $mensaje;
      
      
      //enviar correos
      $to = 'recipient@example.com'; // Dirección del destinatario
      $subject = 'Asunto del correo'; // Asunto del correo
      $message = 'Este es el cuerpo del correo electrónico.'; // Cuerpo del mensaje
      $headers = 'From: sender@example.com' . "\r\n" . // Cabeceras adicionales
                 'Reply-To: sender@example.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion(); // Cabecera X-Mailer

      // Enviar el correo
      if (mail($to, $subject, $message, $headers)) {
        echo 'Correo enviado correctamente.';
      } else {
         echo 'Error al enviar el correo.';
      }
      */

        
        /*
           
        echo "1.." . $s_idReunion;
        echo '<br>';
        echo "2.." . $s_fechaReunion;
        echo '<br>';
        echo "3.." . $s_horaReunion;
        echo '<br>';
        echo "4.." . $s_lugarReunion;
        echo '<br>';
        echo "5.." . $s_convocadaPor;
        echo '<br>';
        echo "6.." . $s_idEntidad;
        echo '<br>';
        echo "7.." . $s_idDependencia;
        echo '<br>';
        echo "8.." . $s_idGrupo;
        echo '<br>';
        echo "9.." . $s_idCategoria;
        echo '<br>';
        echo "10.." . $s_idSubCategoria;
        echo '<br>';
        echo "11.." . $s_detalleReunion;
        echo '<br>';
        echo "11 a.." . $s_desarrolloReunion;
        echo '<br>';
        echo "12.." . $s_estadoReunion;
        echo '<br>';
        echo "13.." . $s_fechaEstado;
        echo '<br>';
         
       */
        $s_tocoBoton="S";
        $mensaje=" <b>Atención!</b> Correos enviados exitosa ¡";
    }
    
    if ( $s_idReunion != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "ENVIAR CORREOS A PARTICIPANTES";
      $s_existe = 1;
      $boton  = "Actualizar";
    
      $sql = "select * from reu_reuniones where idreunion=$s_idReunion";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
    
      $s_idReunion       = $row['idreunion'];
      $s_fechaReunion    = $row['fechareunion'];
      $s_horaReunion     = $row['horareunion'];
      $s_lugarReunion    = $row['lugarreunion'];
      $s_convocadaPor    = $row['convocadapor'];
      $s_idEntidad       = $row['identidad'];
      $s_idDependencia   = $row['iddependencia'];
      $s_idGrupo         = $row['idgrupo'];
      $s_idCategoria     = $row['idcategoria'];
      $s_idSubCategoria  = $row['idsubcategoria'];
      $s_detalleReunion  = $row['detallereunion'];
      $s_desarrolloReunion = $row['desarrolloreunion'];
      $s_estadoReunion   = $row['estadoreunion'];
      $s_fechaEstado     = $row['fechaestado'];

        /*  
        echo "1.." . $s_idReunion;
        echo '<br>';
        echo "2.." . $s_fechaReunion;
        echo '<br>';
        echo "3.." . $s_horaReunion;
        echo '<br>';
        echo "4.." . $s_lugarReunion;
        echo '<br>';
        echo "5.." . $s_convocadaPor;
        echo '<br>';
        echo "6.." . $s_idEntidad;
        echo '<br>';
        echo "7.." . $s_idDependencia;
        echo '<br>';
        echo "8.." . $s_idGrupo;
        echo '<br>';
        echo "9.." . $s_idCategoria;
        echo '<br>';
        echo "10.." . $s_idSubCategoria;
        echo '<br>';
        echo "11.." . $s_detalleReunion;
        echo '<br>';
        echo "11 a.." . $s_desarrolloReunion;
        echo '<br>';
        echo "12.." . $s_estadoReunion;
        echo '<br>';
        echo "13.." . $s_fechaEstado;
        echo '<br>';
        */

    }  

 ?>    
 
               <!-- Page Content Holder -->
              <div id="content">  
                  <!--- MENU CERRAR 
                     <nav class="navbar navbar-default">  ---->
                     <nav>  
                         <div class="container-fluid" style="background-color:#fff; padding:10px;">
                             <div class="navbar-header">
                                 <img src="img/usuario_ap.svg" class="img-circle" alt="Cinque Terre" width=40px; > 
                                 <span style="color:#002857; font-size:1.3em; font-weight:600; "><?=$nombreUsuario?> </span>  
                                 <p style="color:grey; font-size:14px; font-family:snas-serif:">Fecha de último ingreso: </p>
                             </div>
                          </div>
                    <!-- </nav>  ---->
                <!--- FIN MENU CERRAR ---->
                  <br>
                  <!--- BARRA DE TITULO ---->
                  <div class="fondo"> 
                      <div class="row">
                       <div class="col-sm-6" ALIGN="left">
                          <h3> <i class='fas fa-building' style='color:#2f79b9'></i> REUNIÓN </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <a href="reu0.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
                        </div>                
                      </div>
                  </div>
                  <!--- FIN BARRA DE TITULO ----> 
                  
                  <div class="panel panel-info">
                 <div class="panel-heading">
                <div class="btn-group pull-right">        	     
                </div>
              <h4><i class="fa fa-keyboard-o" style='color:#2f79b9'></i> <?=$titulo?>  </h4>
            </div>
      
        <?php  
            if ($s_tocoBoton=="S")
            {
        ?> 
              <div class="alert alert-success" align="center"><?=$mensaje?></div>
        <?php 
            }
        ?>
                <div class="container-fluid">
                    
	                     <div class="panel-body" align="left">
                            <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">   
                                <?php
                                     $sql="select * from  reu_reuniones_participante where idreunion = $s_idReunion";
                                     $stmt = $pdo->query($sql);
                                ?>
                                <div class="table-responsive">
			                        <table class='tablaResponsive table table-striped table-bordered table-hover'>
			                            <th>Identificación</th>
			                            <th>Nombres</th>
			                            <th>Celular</th>
			                            <th>Correo</th>
			                            
			                            <?php
			                                $i=1;
			                                while ($row  = $stmt->fetch(PDO::FETCH_ASSOC)){
			                                        $numeroIdParticipante=$row['numeroidparticipante'];
			                                        $sql_par  = "SELECT * FROM reu_participante where numeroidparticipante=$numeroIdParticipante";
 			                                        $stmt_par = $pdo->query($sql_par);
			                                        $row_par  = $stmt_par->fetch(PDO::FETCH_ASSOC);
			                                        $nombre   = $row_par['nombresparticipante']; 
			                                        $celularparticipante=$row_par['celularparticipante'];
				                                    $correoparticipante=$row_par['correoparticipante'];
			                            ?>
				                        
				                           <tr>	
  		   			                         <td><?php echo $numeroIdParticipante; ?></td>
  					                         <td><?php echo $nombre; ?></td>
  					                         <td><?php echo $celularparticipante; ?></td>
  					                         <td><?php echo $correoparticipante; ?></td>
  					                       </tr>      
  					                 
  					                   <?php
			                              }
			                           ?>       
  					                 
  					                   <tr>
			                              <td colspan="4">
			                                 <button type="submit" name='enviarcorreo' class="btn btn-primary btn-block"><i class="glyphicon glyphicon-edit"></i> Enviar Correo a los Participantes </button>
			                              </td> 
                                       </tr>      
			                        </table>
    			                    <input style="visibility:hidden" name="idReunion" id="idReunion" value="<?=$s_idReunion?>"/>
                                    <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                                    <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
                            </form>
                         </div>    
                     
                </div>  
                                             
        </div> <!-- content -->   
        
        <!--- complemento -->
        <?php
           include("complemento.html");             
        ?>
        <!--- fin complemento -->
    </div> <!-- wrapper -->
            
    <hr>
     <?php
      // include("footer.php");
     ?>
      <script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
     
      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="js/jasny-bootstrap.min.js"></script>
    
  
    </body>
  </html>
  
   
 
                 