

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
  $title="UNP | Reuniones ";    
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
    // Crear una nueva instancia de conexi贸n PDO
    $pdo = new PDO($dsn);
    
    // Configurar el modo de error para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conectado: ";
    // Consulta SQL
    $sql = "SELECT COUNT(*) AS cuantos FROM reu_reuniones";
    // Ejecutar la consulta
    $query = $pdo->query($sql);
    // Obtener el resultado
    $row = $query->fetch(PDO::FETCH_ASSOC);
    // Guardar el resultado en una variable
    $s_cuantos = $row['cuantos'];
     
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
                     </nav>  
                <!--- FIN MENU CERRAR ---->
                <br>
                
                <!--- BARRA DE TITULO ---->
                <div class="fondo"> 
                    <div class="row">
                     <div class="col-sm-6" ALIGN="left">
                        <span align="center"> <?=$s_cuantos?> registradas  </span><br>
                        <h3> <i  class='fas fa-sign-in-alt' style='color:#2f79b9'></i> REUNIONES </h3>
                     </div>
                     <div class="col-sm-6" ALIGN="right">
                       <p style="font-size:12px;"><i class="fas fa-building"></i> <i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                       </div>
                    </div>
                </div>
                <!--- FIN BARRA DE TITULO ---->
                
                <div class="panel panel-info">
	               <div class="panel-heading">
        	          <div class="btn-group pull-right">        	    
          	            <a href="reu1.php?grupoAdic=<?=$s_grupo?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus" ></span> Nueva Reunión</a>
	                  </div>
        	          <h4><i class='glyphicon glyphicon-search'></i> Buscar Reunión</h4>
	               </div>
	               
	               <div class="panel-body">			  	          
  	                 <form class="form-horizontal" role="form" id="datos_cotizacion">
                        <div class="form-group row">
        	              <div class='col-md-3'>
         		             <label>Filtrar por número de reunión</label>
	         	             <input type="text" class="form-control" id="q" placeholder="Reunión" onkeyup='load(1);'>
         		          </div>
         		   
         		          <div class='col-md-3'>
         	                 <label>Convocada por</label>
         	                 <select class='form-control' id='q1' onchange="load(1);">
            		            <option value="">Buscar por quien convoca</option>
	         	                  <?php 
			                         $query_convoca=mysqli_query($con,"select * from reu_participante order by nombresParticipante");
			                         while($rw=mysqli_fetch_array($query_convoca))	{
			                      ?>
                                       <option value="<?php echo $rw['numeroIdParticipante'];?>"><?php echo $rw['nombresParticipante'];?></option>			
			                      <?php
			                         }
			                      ?>  
			                 </select>  
			              </div>
			      
			              <div class='col-md-3'>
         	                 <label>Dependencia</label>
         	                 <select class='form-control' id='q2' onchange="load(1);">
            		           <option value="">Buscar por dependencia</option>
	         	                 <?php 
			                       $query_depende=mysqli_query($con,"select * from reu_dependencias order by nombreDependencia");
			                       while($rw=mysqli_fetch_array($query_depende))	{
			                     ?>
                                  <option value="<?php echo $rw['idDependencia'];?>"><?php echo $rw['nombreDependencia'];?></option>			
			                     <?php
			                      }
			                     ?>  
			                  </select>  
         	              </div>
         	      
         	              <div class='col-md-3'>
         	                 <label>Grupo</label>
         	                 <select class='form-control' id='q3' onchange="load(1);">
            		           <option value="">Buscar por grupo</option>
	         	                 <?php 
			                       $query_grupo=mysqli_query($con,"select * from reu_grupos_internos order by grupoInterno");
			                       while($rw=mysqli_fetch_array($query_grupo))	{
			                     ?>
                                  <option value="<?php echo $rw['idGrupoInterno'];?>"><?php echo $rw['grupoInterno'];?></option>			
			                     <?php
			                      }
			                     ?>  
			                  </select>  
         	              </div>
	             						
        	      
		                 <div class='col-md-12 text-center'>
            		            <span id="loader"></span>
		                 </div>	
        	            </div> <!-- form group -->
                     </form>
                     
                      <div id="resultados"></div><!-- Carga los datos ajax -->
        	          <div class='outer_div'></div><!-- Carga los datos ajax -->			
        	  
                   </div>  <!--- panel body -->   
                </div> <!--- panel info -->
             <!--- complemento -->
              <?php
              include("complemento.html");
            ?>
            <!--- fin complemento --> 
            </div> <!-- content -->
         <hr>
   <?php
    // include("footer.php");
   ?>
   <script type="text/javascript" src="js/reu0.js"></script>
  </body>
</html>
            