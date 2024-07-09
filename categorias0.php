

<?php
 
  session_start();
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
  {
    header("location: login.php");
    exit;
  }
   
  
  $active_marca="active";
  $title="UNP | categoría";  
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
  
  ////  trae cantidad de marcas registradas
   $sql="select count(*) as cuantos from reu_categorias";
   $query = mysqli_query($con, $sql);  
   $row=mysqli_fetch_array($query);
   $s_cuantos = $row['cuantos'];
  ?>
  
            <!-- Page Content Holder -->
            <div id="content">  
                <!--- MENU CERRAR 
                     <nav class="navbar navbar-default">  ---->
                     <nav>  
                         <div class="container-fluid" style="background-color:#fff; paddiong:10px;">
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
                        <span align="center"> <?=$s_cuantos?> registrados  </span><br>
                        <h3> <i  class='fas fa-stream' style='color:#2f79b9'></i> CATEGORÍAS "TEMAS" </h3>
                     </div>
                     <div class="col-sm-6" ALIGN="right">
                       <p style="font-size:12px;"><i class="fas fa-building"></i> <i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                       </div>
                    </div>
                </div>
                <!--- FIN BARRA DE TITULO ---->
                
                <!--- CONTENIDO ---->
                 
                <div class="panel panel-info">
	          <div class="panel-heading">
        	    <div class="btn-group pull-right">        	    
          	      <a href="categorias1?grupoAdic=<?=$s_grupo?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus" ></span> Nueva Categoría</a>
	            </div>
        	  <h4><i class='glyphicon glyphicon-search'></i> Buscar Categoría</h4>
	        </div>
		
        	<div class="panel-body">			  	          
  	          <form class="form-horizontal" role="form" id="datos_cotizacion">
	            <div class="form-group row">
        	      
        	       
        	       <div class='col-md-4'>
         		   <label>Filtrar por nombre de la categoría</label>
	         	   <input type="text" class="form-control" id="q" placeholder="Categoría" onkeyup='load(1);'>
         		</div>
	             						
        	      
		        <div class='col-md-12 text-center'>
            		   <span id="loader"></span>
		        </div>	
        	     </div>
        	  </form>
	  
	          <div id="resultados"></div><!-- Carga los datos ajax -->
        	  <div class='outer_div'></div><!-- Carga los datos ajax -->			
  	         
                </div>
                
                <!--- FIN CONTENIDO ---->
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
   <script type="text/javascript" src="js/categorias.js"></script>
  </body>
</html>
   