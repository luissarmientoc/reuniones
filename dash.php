 
<?php
 session_start();
 
                        $_SESSION['user_id'] = 1; //$result_row->user_id;
		            	$_SESSION['user_name'] = "ADMIN.SISTEMA"; // $result_row->user_name;
                        $_SESSION['user_email'] = "admin@admin.co"; //$result_row->user_email;
                        $_SESSION['user_perfil'] = 1; //$result_row->perfil;
                        $_SESSION['user_firstname'] = "USUARIO"; //$result_row->firstname;
                        $_SESSION['user_lastname'] = "ADMINISTRADOR"; //$result_row->lastname;  
                        
                        $_SESSION['idUt'] = 99; //$result_row->idUt;
                        $_SESSION['nombreUt'] = "UNP"; //$result_row->nombreUt;  
                        
                        $_SESSION['user_login_status'] = 1;
                        
                        if ($_SESSION['user_perfil']==1)
                        {
                            $_SESSION['nombre_perfil']="ADMINISTRADOR";
                        }
                        if ($_SESSION['user_perfil']==3)
                        {
                            $_SESSION['nombre_perfil']="JURIDICO";
                        }
                        if ($_SESSION['user_perfil']==4)
                        {
                            $_SESSION['nombre_perfil']="FINANCIERO";
                        }
                        if ($_SESSION['user_perfil']==5)
                        {
                            $_SESSION['nombre_perfil']="UT";
                        }
                        
 $nomUusuario = $_SESSION['user_name'];
 $emaiUsuario = $_SESSION['user_email'];
 $nomUsuarioI = $_SESSION['user_firstname'];
 $apeUsuarioI = $_SESSION['user_lastname'];      
 $idBodega    = $_SESSION['laBodega'];    
 $nomBodega   = $_SESSION['laTienda'];     

  include("head.php");
 // include("navbar.php");
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
                           <i class='fas fa-building' style='font-size:20px;color:#3498db;'></i>
                           <span class="titDash1"> Entidades </span></br>  
                           <span class="titDash2"> <?=$fechas?> </span><br>   
                           <span style="color:#16a085; font-size:14px;"> <a href="entidad0.php"> <?=$cantEntidades?> Registradas <i class="fas fa-link"></i></a> </span>                         
                         </div>  
                       </div>
                       
                        <div class="col-sm-4" ALIGN="CENTER">
                         <div class="fondo"> 
                           <i class="fas fa-gopuram" style='font-size:20px;color:#2f79b9'></i> 
                           <span class="titDash1"> Dependencias </span></br>
                           <span class="titDash2"> <?=$fechas?> </span><br>
                           <span style="color:#2f79b9; font-size:14px;"> <a href="dependencia0.php">  <?=$cantDependencias?> Registradas <i class="fas fa-link"></i></a> </span>
                         </div>  
                       </div>   

                      <div class="col-sm-4" ALIGN="CENTER">
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
                           <span style="color:#3498db; font-size:14px;"> <a href="cli00.php">  <?=$cantPersonas?> Registrados <i class="fas fa-link"></i></a> </span>                          
                         </div>  
                       </div>                         
                  </div>  <!-- row -->
                  
  
                  <!-------------------------->  
                  <!-- FIN DATOS DE CABECERA -->
                  <!-------------------------->
                  
                   
             <!-------------------------->  
             <!-- barras -->     
             <!-------------------------->
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
                     
                     
             
             
              
            <!--- complemento -->
            <?php
             include("complemento.html");             
            ?>
            <!--- fin complemento -->
          </div> <!-- wrapper -->