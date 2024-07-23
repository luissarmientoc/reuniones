 
<?php
 session_start();
 $nomUusuario = $_SESSION['user_name'];
 $emaiUsuario = $_SESSION['user_email'];
 $nomUsuarioI = $_SESSION['user_firstname'];
 $apeUsuarioI = $_SESSION['user_lastname'];      
 $idBodega    = $_SESSION['laBodega'];    
 $nomBodega   = $_SESSION['laTienda'];     
  
  
  $active_inicio="active";
  $title="UNP| Inicio";
   
  
  /* Connect To Database*/
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
  include("head.php");
  include("navbar.php");
  $fechas ="HOY";
  $fecha=strftime( "%Y-%m-%d", time() );
  
  //$fecha=date("Y-m-d",strtotime($s_fecha."- 1 days")); 
  //sumo 1 día
  $fMasUno =  date("Y-m-d",strtotime($s_fecha."+ 1 days")); 
  
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
  
  $s_fecIni="10/10/2020";
  $s_fecFin="30/15/2023";
  
  if ($s_fecIni!="" and $s_fecFin!="")
  {
  
    $sqlEsquemas  = "select count(*) as cuantosEsquemas from sl_esquema";
    $sqlPersonas  = "select count(*) as cuantosPersonas from sl_personas";
    $sqlUt        = "select count(*) as cuantosUt from sl_ut";
    $sqlZonas     = "select count(*) as cuantosZonas from sl_zonas";
    $sqlAuditoriaPorIniciar = "select count(*) as cuantosPorIniciar from sl_auditoria_encabezado where nombreEstado = 'Por Iniciar'";
    $sqlAuditoriaTerminada = "select count(*) as cuantosTerminada from sl_auditoria_encabezado where nombreEstado = 'Terminado'";

    
            
     
  }  
  else
  {   
    $_SESSION['fecha']  = $fecha;
    $_SESSION['fecha1'] = $fMasUno;
    
    $sqlEsquemas  = "select count(*) as cuantosEsquemas from sl_esquema";
    $sqlPersonas  = "select count(*) as cuantosPersonas from sl_personas";
    $sqlUt        = "select count(*) as cuantosUt from sl_ut";
    $sqlZonas     = "select count(*) as cuantosZonas from sl_zonas";
    $sqlAuditoriaPorIniciar = "select count(*) as cuantosPorIniciar from sl_auditoria_encabezado where nombreEstado = 'Por Iniciar'";
    $sqlAuditoriaTerminada = "select count(*) as cuantosTerminada from sl_auditoria_encabezado where nombreEstado = 'Terminado'";
     
  }
  
  
    $queryEsquema = mysqli_query($con, $sqlEsquemas); 
    $lineEsquema  = mysqli_fetch_array($queryEsquema );
    $cantEsquemas= $lineEsquema  ['cuantosEsquemas'];
    
    $queryPersona = mysqli_query($con, $sqlPersonas); 
    $linePersona  = mysqli_fetch_array($queryPersona);
    $cantPersona= $linePersona  ['cuantosPersonas'];
  
    $queryUt = mysqli_query($con, $sqlUt); 
    $lineUt  = mysqli_fetch_array($queryUt );
    $cantUt  = $lineUt  ['cuantosUt'];
   
    $queryZonas = mysqli_query($con, $sqlZonas); 
    $lineZonas  = mysqli_fetch_array($queryZonas );
    $cantZonas = $lineZonas  ['cuantosZonas'];
    
    $queryAuditoriaPorIniciar = mysqli_query($con, $sqlAuditoriaPorIniciar); 
    $lineAuditoriaPorIniciar  = mysqli_fetch_array($queryAuditoriaPorIniciar);
    $cantAuditoriaPorIniciar = $lineAuditoriaPorIniciar  ['cuantosPorIniciar'];
    
    $queryAuditoriaTerminada = mysqli_query($con, $sqlAuditoriaTerminada); 
    $lineAuditoriaTerminada  = mysqli_fetch_array($queryAuditoriaTerminada);
    $cantAuditoriaTerminada = $lineAuditoriaTerminada  ['cuantosTerminada'];
    
    /*
    echo '<br>';
    echo "esquemas:.. " . $cantEsquemas;
    echo '<br>';
    echo "cantPersona:.. " . $cantPersona;
    echo '<br>';
    
    echo '<br>';
    echo "cantUt  :.. " . $cantUt ;
    echo '<br>';
    
    echo '<br>';
    echo "cantZonas :.. " . $cantZonas ;
    echo '<br>';
    
    echo '<br>';
    echo "cantAuditoriaPorIniciar :.. " . $cantAuditoriaPorIniciar ;
    echo '<br>';
    
    echo '<br>';
    echo "cantAuditoriaTerminada :.. " . $cantAuditoriaTerminada ;
    echo '<br>';
    */
?>

            <!-- Page Content Holder -->
            <div id="content">  
                     <!--- MENU CERRAR ---->
                     <nav class="navbar navbar-default">
                         <div class="container-fluid">
                             <div class="navbar-header">
                                 <button type="button" id="sidebarCollapse" class="btn btn-warning navbar-btn">
                                     <i class="fas fa-arrows-alt-h"></i>
                                     <span>Menú</span>                                
                                 </button>                                          
                             </div>
                          </div>
                     </nav>
                     <!--- FIN MENU CERRAR ---->
                
                   
                   <!--- BARRA DE TITULO ---->
                     <div class="fondo"> 
                       <div class="row">
                          <div class="col-sm-7" ALIGN="left">
                            <span align="center">UNIDAD DE PROTECCIÓN NACIONAL </span><br>
                            <!-- <h3> <i class='fas fa-receipt' style="font-size:28px;color:#2980b9"></i>  FACTURACIÓN </h3> -->
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
                   
                   
                    <!----------------------->
                   <!-- DATOS DE CABECERA -->
                   <!----------------------->
                
                  <div class="row"> <!-- row -->
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class='fas fa-sign-in-alt' style='font-size:20px;color:#3498db;'></i>
                           <span class="titDash1"> Seguimiento(s) en Curso</span></br>  
                           <span class="titDash2"> <?=$fechas?> </span><br>   
                           <span style="color:#16a085; font-size:14px;"> <a href="seguimientos.php"> <?=$s_enCurso?> En Curso <i class="fas fa-link"></i></a> </span>                         
                         </div>  
                       </div>
                       
                        <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-images" style='font-size:20px;color:#2f79b9'></i> 
                           <span class="titDash1"> Seguimiento(s) por Iniciar </span></br>
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#2f79b9; font-size:14px;"> <a href="seguimientos.php">  <?=$cantAuditoriaPorIniciar?> Por Iniciar<i class="fas fa-link"></i></a> </span>
                         </div>  
                       </div>   
                      
                      <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-retweet" style='font-size:20px;color:#e67e22'></i>
                           <span class="titDash1"> Seguimiento(s) Terminado(s)</span></br>  
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#e67e22; font-size:14px;"> <a href="seguimientos.php">  <?=$cantAuditoriaTerminada?> Terminadas <i class="fas fa-link"></i></a> </span>                          
                         </div>  
                       </div>   
                   </div>  <!-- row -->             
                  
                   <div class="row"> <!-- row -->
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class='fas fa-puzzle-piece' style='font-size:20px;color:#2980b9;'></i>  
                             <span class="titDash1"> Esquemas </span><br>
                             <span class="titDash2"> <?=$fechas?> </span><br>
                             <span style="color:#2980b9; font-size:14px;"> <a href=""> <?=$cantEsquemas?> Esquemas <i class="fas fa-link"></i> </a> </span>                           
                         </div>
                       </div>  
                       
                       
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-building" style='font-size:20px;color:#8e44ad'></i> 
                           <span class="titDash1"> Unión Temporal</span></br>
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#8e44ad; font-size:14px;"> <a href="">   <?=$cantUt?> Unión Temporal <i class="fas fa-link"></i></a> </span>
                         </div>  
                       </div>
                       
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-user-shield" style='font-size:20px;color:#3498db'></i>
                           <span class="titDash1"> Personal de Seguridad </span></br>  
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#3498db; font-size:14px;"> <a href="cli00.php">  <?=$cantPersona?> Personas <i class="fas fa-link"></i></a> </span>                          
                         </div>  
                       </div>                         
                  </div>  <!-- row -->
                  
  
                  <!-------------------------->  
                  <!-- FIN DATOS DE CABECERA -->
                  <!-------------------------->
                  
                   <!----------------------->
                   <!-- DATOS DE CABECERA -->
                   <!----------------------->
                
                  <div class="row"> <!-- row -->
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo" style="background-color: #34495e;">                           
                           <i class='fas fa-clipboard' style='font-size:16px;color:#fff;'></i>
                           <span style='font-size:18px;color:#fff;'> Sanciones </span></br>  
                           <span style='font-size:14px;color:#fff;'> <?=$fechas?> </span><br>   
                           <span style="color:#fff; font-size:14px; font-family:verdana;"> <a href="facturas.php"> <?=$s_generadas?> Seguimiento(s) <i class="fas fa-link"></i></a> </span>  <br>                       
                           <span style="color:#fff; font-size:16px; font-family:verdana;">$ <?=number_format($s_totalG)?> </span>                         
                            
                         </div>  
                       </div>
                       
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo" style="background-color: #3498db;">                           
                           <i class='fas fa-briefcase ' style='font-size:16px;color:#fff;'></i>
                           <span style='font-size:18px;color:#fff;'> Supervisión Jurídica </span></br>  
                           <span style='font-size:14px;color:#fff;'> <?=$fechas?> </span><br>   
                           <span style="color:#fff; font-size:14px; font-family:verdana;"> <a href="facturas.php">  <?=$s_anuladas?> Seguimiento(s) <i class="fas fa-link"></i> </a></span>  <br>                       
                                                 
                           
                         </div>  
                       </div>
                       
                       <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo" style="background-color: #00a89d;">                           
                           <i class='fas fa-money-check-alt' style='font-size:18px;color:#fff;'></i>
                           <span style='font-size:16px;color:#fff;'> Supervisión Financiera </span></br>  
                           <span style='font-size:14px;color:#fff;'> <?=$fechas?> </span><br>   
                           <span style="color:#fff; font-size:14px; font-family:verdana;"><a href="facturas.php"><?=number_format($s_crProd)?>  Seguimiento(s) <i class="fas fa-link"></i></a></span>  <br>                       
                                                    
                           
                         </div>  
                       </div>                       
                            
                  </div>  <!-- row -->
                  
                  <div class="container">
  	            <div class="col-sm-6">
                      <?php
  	                include("op_cons_externa.php");  	             
  	               ?>  
  	             </div>
  	             
  	             <div class="col-sm-6">
                      <?php
  	                include("op_cons_hospital.php");  	             
  	               ?>  
  	             </div>  
  	             
  	             <div class="col-sm-6"><br><br>
                      <?php
  	                include("op_cons_urgencias.php");  	             
  	               ?>  
  	             </div>  
  	              
                   </div> 	
  	         
                    
                
            <!--- complemento -->
            <?php
             include("complemento.html");             
            ?>
            <!--- fin complemento -->
          </div> <!-- wrapper -->