 
 
<?php
 session_start();
 $nomUusuario = $_SESSION['user_name'];
 $emaiUsuario = $_SESSION['user_email'];
 $nomUsuarioI = $_SESSION['user_firstname'];
 $apeUsuarioI = $_SESSION['user_lastname'];      
 
 /*
 echo "1.." . $nomUusuario ;
 echo '<br>';
 echo "2.." . $emaiUsuario;
 echo '<br>';
 echo "3.." . $nomUsuarioI;
 echo '<br>';
 echo "4.." . $apeUsuarioI;      
 echo '<br>';
 echo "5.." . $idBodega;    
 echo '<br>';
 echo "6.." . $nomBodega;     
 */

 $nombreUsuario=$nomUsuarioI . " " . $apeUsuarioI;
 
 require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
 require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

 include("head.php");
 include("navbar.php");
 // Crear una nueva instancia de conexión PDO
 $pdo = new PDO($dsn);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
  $fechas ="HOY";
  $fecha=strftime( "%Y-%m-%d", time() );
  
  // Supongamos que tienes una fecha en formato YYYY-MM-DD
  $fecha_actual = $fecha;

  // Creamos un objeto DateTime a partir de la fecha actual
  $fecha_obj = new DateTime($fecha_actual);

  // Restamos un año usando el método modify()
  $fecha_obj->modify('-1 year');

  // Obtenemos la fecha modificada en formato deseado (YYYY-MM-DD)
  $fecha_modificada = $fecha_obj->format('Y-m-d');

  echo "Fecha original: " . $fecha_actual . "<br>";
  echo "Fecha modificada (restado 1 año): " . $fecha_modificada;
  
  echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
  
  //$fecha=date("Y-m-d",strtotime($s_fecha."- 1 days")); 
  $fecha=$fecha_modificada;
  //sumo 1 día
  $fMasUno =  date("Y-m-d",strtotime($s_fecha."+ 1 days")); 
  //$fMasUno = $fecha_modificada;
  
  $_SESSION['fecha']  = $fecha;
  $_SESSION['fecha1'] = $fMasUno;
   
  if(isset($_POST['consultar']))   
  {
    $s_fecIni = $_POST['fecIni'];
    $s_fecFin = $_POST['fecFin'];
    
     $_SESSION['fecha']  = $s_fecIni;
     $_SESSION['fecha1'] = $s_fecFin;
    
    if ($s_fecIni!="" and $s_fecFin!="")
    {
     $fechas = "Desde: " . $s_fecIni . " hasta ". $s_fecFin;
    } 
  }//consultar
  
  if ($s_fecIni!="" and $s_fecFin!="")
  {
      
  }    
  else
  {   
    $_SESSION['fecha']  = $fecha;
    $_SESSION['fecha1'] = $fMasUno;
    $s_fecIni= $fecha;
    $s_fecFin= $fMasUno;
  }

   try {
     
      //Entidades registradas
      $sql = 'SELECT count(*) as cuantos FROM reu_entidades';
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $cantEntidades = $row['cuantos'];
        
      //Dependencias registradas
      $sql = 'SELECT count(*) as cuantos FROM reu_dependencias';
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $cantDependencias = $row['cuantos'];
      
      //Grupos internos registrados
      $sql = 'SELECT count(*) as cuantos FROM reu_grupos_internos';
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $cantGrupos = $row['cuantos'];
    
      //Categorias registradas  
      $sql = 'SELECT count(*) as cuantos FROM reu_categorias';
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $cantCategorias = $row['cuantos'];
      
      //Subcategorias registradas   
      $sql = 'SELECT count(*) as cuantos FROM reu_sub_categorias';
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $cantSubCategorias = $row['cuantos'];
      
      //Participantes registrados 
      $cantPersonas = 0;
      $sql = 'SELECT count(*) as cuantos FROM reu_reuniones_participante group by numeroidparticipante';
      $stmt = $pdo->query($sql);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cantPersonas = $cantPersonas + 1;
       }
       
      //Subcategorias registradas   
      $sql = 'SELECT count(*) as cuantos FROM reu_lugares';
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $cantLugares = $row['cuantos'];
       
     }catch (PDOException $e) {
      echo "Error de conexión: " . $e->getMessage();
    }
    
  
  
?>


            <!-- Page Content Holder -->
            <div id="content" style="background-color:#fff;" style="width:100%">  
                     <!--- MENU CERRAR
                     <nav class="navbar navbar-default"> ---->
                         <div class="container-fluid" style="background-color:#fff;">
                             <div class="navbar-header">
                                 <img src="img/usuario_ap.svg" class="img-circle" alt="Cinque Terre" width=40px; > 
                                 <span style="color:#002857; font-size:1.3em; font-weight:600; "><?=$nombreUsuario?> </span>  
                                 <p style="color:grey; font-size:14px; font-family:snas-serif:">Fecha de último ingreso: </p>
                             </div>
                          </div>
                    <!-- </nav>  ---->
                      
                    <!--- BARRA DE TITULO ---->
                     <div class="fondo"> 
                       <div class="row">
                          <div class="col-sm-7" ALIGN="left">
                            <!--<span align="center">UNIDAD DE PROTECCIÓN NACIONAL </span><br>
                             <h3> <i class='fas fa-receipt' style="font-size:28px;color:#2980b9"></i>  FACTURACIÓN </h3> -->
                            <h3> <i class="fas fa-chart-pie" style="font-size:28px;color:#2980b9"></i>  INICIO </h3>
                            
                          </div>  
                     
                          <div class="col-sm-5" ALIGN="left">
                             <div class="panel-group">
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title"><span style='font-size:14px;color:#2980b9'> Consulta por fechas </span> 
                                      <a data-toggle="collapse" href="#collapse1"> <i class='far fa-calendar-alt' style='font-size:14px;color:#2980b9'></i> </a>
                                     </h4>
                                     
                                   </div>
                                   
                                   <div id="collapse1" class="panel-collapse collapse">
                                     <div class="panel-body">
                                       <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                           <span> Fecha Inicial: </span>
                                           <input class="titDash2" type="date" name="fecIni" required><br><br>
                                           
                                           <span> Fecha Final: </span>
                                           <input class="titDash2" type="date" name="fecFin" required><br><br>
                                           
                                           <button type="submit" name='consultar' class="btn btn-sm btn-success"><i class="glyphicon glyphicon-refresh"></i> Consultar </button>
                                        </form>        
                                      

                                     </div>
                                   </div>
                                
                                </div> <!-- default --> 
                             </div> <!--panel group-->
                             <div align="right">
                               <p style="font-size:12px;"><i class="fas fa-building"></i> <?=$_SESSION['nombreUt'];?>  <i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?> </p>
                             </div>
                           </div>
                       </div>  
                     </div>
                   <!--- FIN BARRA DE TITULO ----> 
                   
                   <!--- DATOS DE CABECERA ---->
                   <?php
                   /*$cantEntidades = 10;
                   $cantDependencias = 3;
                   $cantGrupos = 4;
                   $cantCategorias = 9;
                   $cantSubCategorias = 8;
                   $cantPersonas = 7;*/
                   ?>
                    <div class="row"> <!-- row -->
                       <div class="col-sm-3" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class='fas fa-building' style='font-size:20px;color:#3498db;'></i>
                           <span class="titDash1"> Entidades </span></br>  
                           <span class="titDash2"> <?=$fechas?> </span><br>   
                           <span style="color:#16a085; font-size:14px;"> <a href="entidad0.php"> <?=$cantEntidades?> Registradas <i class="fas fa-link"></i></a> </span>                         
                         </div>  
                       </div>
                       
                        <div class="col-sm-3" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-gopuram" style='font-size:20px;color:#2f79b9'></i> 
                           <span class="titDash1"> Dependencias </span></br>
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#2f79b9; font-size:14px;"> <a href="dependencia0.php">  <?=$cantDependencias?> Registradas <i class="fas fa-link"></i></a> </span>
                         </div>  
                       </div>   
                       
                       <div class="col-sm-3" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-map-marker-alt" style='font-size:20px;color:#2f79b9'></i> 
                           <span class="titDash1"> Lugares/Salas </span></br>
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#2f79b9; font-size:14px;"> <a href="lugar0.php">  <?=$cantLugares?> Registrados <i class="fas fa-link"></i></a> </span>
                         </div>  
                       </div>   

                      <div class="col-sm-3" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-project-diagram" style='font-size:20px;color:#e67e22'></i>
                           <span class="titDash1"> Grupos Internos</span></br>  
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#e67e22; font-size:14px;"> <a href="grupos0.php">  <?=$cantGrupos?> Registrados <i class="fas fa-link"></i></a> </span>                          
                         </div>  
                       </div>   
                   </div>  <!-- row -->             

                   <div class="row"> <!-- row -->
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class='fas fa-stream' style='font-size:20px;color:#2980b9;'></i>  
                             <span class="titDash1"> Categorías </span><br>
                             <span class="titDash2"> <?=$fechas?> </span><br>
                             <span style="color:#2980b9; font-size:14px;"> <a href="categorias0.php"> <?=$cantCategorias?> Registradas <i class="fas fa-link"></i> </a> </span>                           
                         </div>
                       </div>  
                       
                       
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-tasks" style='font-size:20px;color:#8e44ad'></i> 
                           <span class="titDash1"> Sub Categorías</span></br>
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#8e44ad; font-size:14px;"> <a href="subcategorias0.php">   <?=$cantSubCategorias?> Registradas <i class="fas fa-link"></i></a> </span>
                         </div>  
                       </div>
                       
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-user-friends" style='font-size:20px;color:#3498db'></i>
                           <span class="titDash1"> Participantes </span></br>  
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#3498db; font-size:14px;"> <a href="participante0.php">  <?=$cantPersonas?> Registrados <i class="fas fa-link"></i></a> </span>                          
                         </div>  
                       </div>                         
                  </div>  <!-- row -->
                  
                  <!--- FIN DATOS DE CABECERA --->
                  
                  <!--- barras --->  
                  <!-------------------------------
                    <div class="col-sm-12" ALIGN="CENTER">
                         <div class="fondo" style="background-color: #fff;">    
                           <h3>COMPROMISOS Y TAREAS</h3>
                         </di> 
                    </div>  
                    <div class="col-sm-12" ALIGN="CENTER">
                         <div class="fondo" style="background-color: #fff;">                           
                           <i class="fas fa-cogs" aria-hidden="true"  style='font-size:16px;color:#16a085;'></i>
                           <span style='font-size:16px;color:#2c3e50;'> Compromisos </span></br>                                                
                           
                           <span style="color:#c0392b; font-size:16px; font-family:verdana;"> ADQUIRIDOS: <?=number_format($cantCompromisosEstado1)?></span><br>
                           <span style="color:#16a085; font-size:16px; font-family:verdana;"> CUMPLIDOS: <?=number_format($cantCompromisosEstado2)?></span>
                      </div>  
                       <div class="fondo" style="background-color: #fff;">         
                           <?php
                             //  include("barrasCompromisos.php");
                          ?> 
                        </div> 
                     </div>    
                     
                     <div class="col-sm-12" ALIGN="CENTER">
                         <div class="fondo" style="background-color: #fff;">                           
                           <i class="fas fa-chart-line" aria-hidden="true"  style='font-size:16px;color:#16a085;'></i>
                           <span style='font-size:16px;color:#2c3e50;'> Tareas </span></br>                                                
                           
                           <span style="color:#c0392b; font-size:16px; font-family:verdana;"> INICIADAS: <?=number_format($cantTareasEstado1)?></span><br>
                           <span style="color:#16a085; font-size:16px; font-family:verdana;"> CUMPLIDAS: <?=number_format($cantTareasEstado2)?></span>
                         </div>  
                        <div class="fondo" style="background-color: #fff;">         
                           <?php
                               //include("barrasTareas.php");
                          ?> 
                         </div> 
                     </div> 
                     ---------------------->
              <div class="container">
                  <div class="row">
                      <div class="col-sm-12">
                        <div class="fondo" align="center">
                            <h3>Datos desde: <b><?=$s_fecIni?></b> Hasta: <b><?=$s_fecFin?></b></h3>
                        </div>             
                      </div>
                  </div>
              </div>      
             
              <div class="container">
                   
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="fondo">   
                          <?php
                             include("barrasReuniones.php");
                          ?> 
                        </div>  
                      </div>
                      <div class="col-sm-6">
                          <?php
                             include("barrasConvocadasPor.php");
                          ?> 
                      </div>
                  </div>
                  <br><br>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="fondo">   
                          <?php
                               include("barrasDependencias.php");
                          ?> 
                        </div>  
                      </div>
                      <div class="col-sm-6">
                        <div class="fondo">
                          <?php
                            include("barrasGrupos.php");
                          ?> 
                        </div>  
                      </div>
                  </div> <!-- row -->
                  
                  <br><br>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="fondo">  
                          <?php
                             include("barrasCategorias.php");
                          ?> 
                        </div>  
                      </div>
                      <div class="col-sm-6">
                        <div class="fondo">  
                          <?php
                             include("barrasSubcategorias.php");
                          ?> 
                        </div>  
                      </div>
                  </div> <!--- row -- >
              </div> <!-- container-->
                  
             </div>  <!-- container --> 	
             
             <!-------------------------->  
             <!-- barras -->     
             <!-------------------------->   
             
            <?php
                include("complemento.html");
            ?> 
 </div> 
            