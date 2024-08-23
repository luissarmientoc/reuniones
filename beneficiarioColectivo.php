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
  $title="UNP | Beneficiarios Colectivo";  
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
    $s_registro                 = $partir[0];
    $no_documento_ben_colectivo = $partir[1];
    $tipAccion                  = $partir[2];
    /*
    echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
    echo "registro.." . $s_registro;
    echo '<br>';
    echo "registro.." . $no_documento_ben_colectivo;
    */
    
    if ( $no_documento_ben_colectivo != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "MODIFICAR BENEFICIARIO DEL COLECTIVO";
      $s_existe = 1;
      $boton  = "Actualizar";
    }
     else
    {
      $titulo = "NUEVA BENEFICIARIO DEL COLECTIVO";
      $s_existe = 0;
      $boton="Grabar";
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
                          <h3> <i class='fas fa-building' style='color:#2f79b9'></i> BENEFICIARIO DEL COLECTIVO </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <?php
                          $lv   = $s_registro . "/MOD1234567890qwertyuiopasdfghjkl";
					      $lVDX = base64_encode($lv);
					     ?> 
                         <a href="graerrFormulario1.php?LA=<?=$lVDX?>" class='btn btn-default pull-right btn-md' title='Regresar' ><<i class="fas fa-reply"></i> Regresar</a> 
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
            
            <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"
	            <div class="row" style="margin-top:5px;">
	                <div class="col-sm-6" align="left">
                        <label for="tipo_documento">TIPO DE DOCUMENTO DEL BENEFICIARIO DEL COLECTIVO</label>
                        <!--<input type="text" class="form-control" id="tipo_documento" name="tipo_documento"  value="<?=$tipo_documento_beneficiario_colectivo?>" required>-->
                        <select <?=$active?> required class="form-control" name="tipo_documento_beneficiario_colectivo">
                            <?php echo $combo_tipo_documento; ?>
                        </select> 
                    </div>
                                
                    <div class="col-sm-6" align="left">
                        <label for="no_documento">No DE DOCUMENTO DEL BENEFICIARIO DEL COLECTIVO</label>
                        <input type="number" class="form-control" id="no_documento_beneficiario_colectivo" name="no_documento_beneficiario_colectivo"  value="<?=$no_documento_beneficiario_colectivo?>" required>
                    </div>
                </div> <!--row-->
                
            </form>    
                 
             <!--- complemento -->
              <?php
              include("complemento.html");
            ?>
         <hr>
   <?php
    // include("footer.php");
   ?>
   
  </body>
</html>            
            