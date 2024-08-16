

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
  $title="UNP | Formulario GRAERR ";    
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
    
    // Configurar el modo de error para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conectado: ";
    // Consulta SQL
    $sql = "SELECT COUNT(*) AS cuantos FROM graerr_formulario_b";
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
                        <span align="center"> <?=$s_cuantos?> registrado  </span><br>
                        <h3> <i  class='fas fa-sign-in-alt' style='color:#2f79b9'></i> Grupo de Recepción, Análisis, Evaluación del Riesgo y Recomendaciones - GRAERR </h3>
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
          	            <a href="graerrFormulario1.php?grupoAdic=<?=$s_grupo?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus" ></span> Nueva Reunión</a>
	                  </div>
        	          <h4><i class='glyphicon glyphicon-search'></i> Buscar Registro</h4>
	               </div>
	               
	               <div class="panel-body">			  	          
  	                 <form class="form-horizontal" role="form" id="datos_cotizacion">
                        <div class="form-group row">
        	              <div class='col-md-3'>
         		             <label>Filtrar por número de registro</label>
         		             <input type="number" class="form-control" id="q" placeholder="Número de registro" onkeyup='load(1);'>
         		     
	         	             <!--<input type="text" class="form-control" id="q" placeholder="Reunión" onkeyup='load(1);'>-->
         		          </div>
         		          
         		          <div class='col-md-3'>
         		             <label>Filtrar por Id del beneficiario</label>
         		             <input type="number" class="form-control" id="q1" placeholder="Id del beneficiario" onkeyup='load(1);'>
         		     
	         	             <!--<input type="text" class="form-control" id="q" placeholder="Reunión" onkeyup='load(1);'>-->
         		          </div>
         		          
         		          <div class='col-md-3'>
         		             <label>Filtrar por nombre del beneficiario</label>
         		             <input style="text-transform:uppercase;" type="text" class="form-control" id="q2" placeholder="Nombre del beneficiario" onkeyup='load(1);'>
         		     
	         	             <!--<input type="text" class="form-control" id="q" placeholder="Reunión" onkeyup='load(1);'>-->
         		          </div>
         		   
         		          <div class='col-md-3'>
         	                 <label>Tipo de ruta</label>
         	                 <select class='form-control' id='q3' onchange="load(1);">
            		            <option value="">Buscar por tipo de ruta</option>
            		              <?php
            		                $stmt = $pdo->query('select * from graerr_tipo_ruta order by tipo_ruta');
            		                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            		              ?>
            		                  <option value="<?php echo $row['id'];?>"><?php echo $row['tipo_ruta'];?></option>			
            		              <?php
            		                 }
			                      ?>  
			                 </select>  
			              </div>
			      
			              <div class='col-md-3'>
         	                 <label>Analista de riesgos</label>
         	                 <select class='form-control' id='q4' onchange="load(1);">
            		           <option value="">Buscar por analista de riesgos</option>
            		             <?php
            		                $stmtAr = $pdo->query('select * from graerr_analista_riesgo order by nombre_analista');
            		                while ($rowAr = $stmtAr->fetch(PDO::FETCH_ASSOC)) {
            		              ?>
            		                  <option value="<?php echo $rowAr['id'];?>"><?php echo $rowAr['nombre_analista'];?></option>			
            		              <?php
            		                 }
			                      ?> 
			                  </select>  
         	              </div>
         	      
         	              <div class='col-md-3'>
         	                 <label>Analista de solicitudes</label>
         	                 <select class='form-control' id='q5' onchange="load(1);">
            		           <option value="">Buscar por analista de solicitudes</option>
            		             <?php
            		                $stmtAs = $pdo->query('select * from graerr_analista_solicitudes order by nombre_analista');
            		                while ($rowAs = $stmtAs->fetch(PDO::FETCH_ASSOC)) {
            		              ?>
            		                  <option value="<?php echo $rowAs['id'];?>"><?php echo $rowAs['nombre_analista'];?></option>			
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
   <script type="text/javascript" src="js/graerr.js"></script>
  </body>
</html>
            