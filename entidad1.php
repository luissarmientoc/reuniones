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
  $title="UNP | Entidad";    
  $nombreUsuario = $_SESSION['user_firstname'] ." " .$_SESSION['user_lastname'] ;
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
    
    $s_idEntidad   = $partir[0];
    $tipAccion     = $partir[1];
    
    
    if ( $s_idEntidad != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "MODIFICAR ENTIDAD";
      $s_existe = 1;
      $boton  = "Actualizar";
      
      $sql = "select * from reu_entidades where idEntidad=$s_idEntidad";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      //echo "Nombre: {$row['des_categoriareunion']}<br />";
      $s_idEntidad     = $row['idEntidad'];
      $s_nombreEntidad = $row['nombreEntidad'];
    
    }  
    else
    {
      $titulo = "NUEVA ENTIDAD";
      $s_existe = 0;
      $boton="Grabar";
    }  
    
    
   if(isset($_POST['grabar']))
   {   
     $s_idEntidad     = $_POST['idEntidad'];
     $s_nombreEntidad = $_POST['nombreEntidad'];
     $s_nombreEntidad = strtoupper($s_nombreEntidad);
   
     $s_existe         = $_POST['existe'];
     $s_yaGrabo        = $_POST['yaGrabo'];
    
     date_default_timezone_set('America/Bogota');
     //$s_fecha  = date("Y-m-d",time());
     //$s_fecha  = date("Y/m/d H:i:s");
     $date_added=date("Y-m-d H:i:s");
      
      ///MODIFICA
      if ($s_existe == "1")  
      {
        $sql="UPDATE reu_entidades SET nombreEntidad ='".$s_nombreEntidad."' WHERE idEntidad='".$s_idEntidad."'";
        //$query_update = mysqli_query($con,$sql);  
        
        $mensaje=" <b>Atención!</b> Actualización exitosa";
      }  
      
      ///ADICIONA
      if ($s_existe == "0")
      {
        $sql1 = "select max(idEntidad) as maximo from reu_entidades ";
        //$query1 = mysqli_query($con, $sql1);  
        //$row1=mysqli_fetch_array($query1);
        
        $s_idEntidad     = $row1[maximo]+1;
        $sql="INSERT INTO reu_entidades (idEntidad, nombreEntidad) VALUES ('$s_idEntidad', '$s_nombreEntidad' )";
        
        //$query_new_insert = mysqli_query($con,$sql);
        $mensaje=" <b>Atención!</b> Grabación exitosa ¡";
        
        $s_existe ="1";
      }
      $s_tocoBoton = "S";  
   }//grabar
   
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
                          <h3> <i class='fas fa-building' style='color:#2f79b9'></i> ENTIDAD </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <a href="entidad0.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
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
                  
              <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">			 
               <div class="panel-body">
                  <div class="row">
                    <div class=" col-md-9 col-lg-9 "> 
                        <table class="table table-condensed">
                         <tbody>
                          <tr>
                              <td class='col-md-3' align="right"> Nombre de la Entidad: </td>
                              <td> <textarea class="form-control" id="nombreEntidad" name="nombreEntidad" required style="text-transform:uppercase;"><?=$s_nombreEntidad?></textarea> </td>
                          </tr> 
                         </tbody>
                        </table>			
                     </div>        	      
                  </div> <!--row-->        	       
                </div> <!-- panel body -->	 
              
               <div class="modal-footer"> 
                <div class="col-sm-11" align="right">  					  			 
                  <button type="submit" name='grabar' class="btn btn-md btn-success"><i class="glyphicon glyphicon-refresh"></i> <?=$boton?> </button>
                </div>	 
              </div>
         
             <input style="visibility:hidden" name="idEntidad" id="idEntidad" value="<?=$s_idEntidad?>"/>
             <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
             <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
              <input type="hidden" class="form-control" id="id_banner" value="<?php echo intval($s_idZona);?>" name="id_banner">
            </form>                                
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
  
   