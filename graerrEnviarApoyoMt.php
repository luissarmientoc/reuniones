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
  $title="UNP | Enviar Apoyo MT";    
  $nombreUsuario = $_SESSION['user_firstname'] ." " .$_SESSION['user_lastname']; 
?>

<html lang="en">
  <head>
    <?php 
      require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
      require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
      // require("modal.php");
       include("head.php");
    ?>
    
    <script>
         function confirmarEnvio(){
                 if(confirm('¿Esta  seguro de enviar el Registro?'))
                   return true;
                 else
                   return false;
             }
             
    </script>
  
  </head>
  
  <?php  
    include("navbar.php");
    // Crear una nueva instancia de conexión PDO
    $pdo = new PDO($dsn);
   
    $s_LA    = $_GET['LA'];
    $linDeco = base64_decode($s_LA);
   
    //PARTE LA LINEA
    $partir      = explode ("/", $linDeco);   
    
    $s_registro   = $partir[0];
    $tipAccion    = $partir[1];
    
    if ( $s_registro != "" )
    {  
             ///////////////////////////////////////////////////////  
             ////// REALIZA LA CONSULTA  
             $sql = "select * from graerr_formulario_b where registro=$s_registro";
             $stmt = $pdo->query($sql);
             $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      
             $s_registro                    = $row['registro'];
             $tipo_estudio_riesgo           = $row['tipo_estudio_riesgo'];
             $ot                            = $row['ot'];
             $fecha_asignado_ot             = $row['fecha_asignado_ot'];
             $tipo_documento                = $row['tipo_documento'];
             $no_documento                  = $row['no_documento'];
             $nombres_peticionario          = $row['nombres_peticionario'];
             $apellidos_peticionario        = $row['apellidos_peticionario'];
             $analista_riesgo               = $row['analista_riesgo'];
             $recomendacion_riesgo_premesa  = $row['recomendacion_riesgo_premesa'];
             $recomendacion_medidas_premesa = $row['recomendacion_medidas_premesa'];
             $departamento                  = $row['departamento'];
             $municipio                     = $row['municipio'];
             $no_de_contacto                = $row['no_de_contacto'];
             $factor_diferencial            = $row['factor_diferencial'];
             $subpoblacion                  = $row['subpoblacion'];
    } 
    
    if(isset($_POST['enviar']))
    { 
             $s_existe         = $_POST['existe'];
             $s_yaGrabo        = $_POST['yaGrabo'];
             date_default_timezone_set('America/Bogota');
             //$s_fecha  = date("Y-m-d",time());
             //$s_fecha  = date("Y/m/d H:i:s");
             $date_added=date("Y-m-d H:i:s");
             
             $s_registro                    = $_POST['registro'];
             $tipo_estudio_riesgo           = $_POST['tipo_estudio_riesgo'];
             $ot                            = $_POST['ot'];
             $tipo_documento                = $_POST['tipo_documento'];
             $no_documento                  = $_POST['no_documento'];
             $nombres_peticionario          = $_POST['nombres_peticionario'];
             $apellidos_peticionario        = $_POST['apellidos_peticionario'];
             $analista_riesgo               = $_POST['analista_riesgo'];
             $recomendacion_riesgo_premesa  = $_POST['recomendacion_riesgo_premesa'];
             $recomendacion_medidas_premesa = $_POST['recomendacion_medidas_premesa'];
             $departamento                  = $_POST['departamento'];
             $municipio                     = $_POST['municipio'];
             $no_de_contacto                = $_POST['no_de_contacto'];
             $factor_diferencial            = $_POST['factor_diferencial'];
             $subpoblacion                  = $_POST['subpoblacion'];
             $obsadicionales_graerr         = $_POST['obsadicionales_graerr'];
             $estado                        = $_POST['estado'];
             
            try {
                 // Conectar a la base de datos
                 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                 // Preparar la consulta SQL para actualizar
                 //variables que se actualizan en MT
                 $conteo_acta = 0;
                 $conteo_porsesion = 0;
                 $consenso = '';
                 $orden = 0; 
                 $temporalidad = 0;
                 $obs_temporalidad="";
                 $motivacion="";
                 $observaciones_smt="";
                 $estado=1;
                 $fecha_estado = date("Y-m-d");
                 
                 $stmt = $pdo->prepare('INSERT INTO mt_anexotecnico_1 (
                        registro, conteo_acta, conteo_porsesion, tipo_estudio, ot,
                        tipo_documento, no_documento, nombres_peticionario, apellidos_peticionario, analista_riesgo, 
                        recomendacion_riesgo_premesa, recomendacion_medidas_premesa, consenso, orden, temporalidad, 
                        obs_temporalidad, departamento, municipio, subpoblacion, factor_diferencial, 
                        no_de_contacto, motivacion, obsadicionales_graerr, observaciones_smt, estado, fecha_estado
                       ) VALUES (?, ?, ?, ?, ?,
                                 ?, ?, ?, ?, ?,
                                 ?, ?, ?, ?, ?,
                                 ?, ?, ?, ?, ?,
                                 ?, ?, ?, ?, ?');
                  
                  $stmt->execute([
                         $s_registro, $conteo_acta, $conteo_porsesion, $tipo_estudio_riesgo, $ot, 
                         $tipo_documento, $no_documento, $nombres_peticionario, $apellidos_peticionario, $analista_riesgo,
                         $recomendacion_riesgo_premesa, $recomendacion_medidas_premesa, $consenso, $orden, $temporalidad,
                         $obs_temporalidad, $departamento,$municipio, $subpoblacion, $factor_diferencial,
                         $no_de_contacto, $motivacion, $obsadicionales_graerr, $observaciones_smt, $estado, $fecha_estado
                  ]);    
                  
                  $mensaje=" <b>Atención!</b> Envio de Registro Exitoso ¡";     
               } catch (PDOException $e) {
                 echo "Error al insertar los datos del formulario: " . $e->getMessage();
            }
    }//enviar
    
             // Decodifica campos
             //tipo_documento
             $sql1 = "select * from graerr_tipo_documento where id=$tipo_documento";
             $stmt1   = $pdo->query($sql1);
             $row1      = $stmt1->fetch(PDO::FETCH_ASSOC);
             $documento = $row1['tipo_documento'];
        
             $sql2 = "select nombre_analista from graerr_analista_riesgo where id=$analista_riesgo";
             $stmt2     = $pdo->query($sql2);
             $row2      = $stmt2->fetch(PDO::FETCH_ASSOC);
             $analista  = $row2['nombre_analista'];
             
             $sql3 = "select descripcion from graerr_recomendacion_premesa where id=$recomendacion_medidas_premesa";
             $stmt3     = $pdo->query($sql3);
             $row3      = $stmt3->fetch(PDO::FETCH_ASSOC);
             $rec_med_prem  = $row3['descripcion'];
             
             $sql4 = "select factor_diferencial from graerr_factor_diferencial where id=$factor_diferencial";
             $stmt4         = $pdo->query($sql4);
             $row4          = $stmt4->fetch(PDO::FETCH_ASSOC);
             $fact_dif      = $row4['factor_diferencial'];
        
             $sql5 = "select descripcion from graerr_poblacion where id=$subpoblacion";
             $stmt5         = $pdo->query($sql5);
             $row5          = $stmt5->fetch(PDO::FETCH_ASSOC);
             $subpob        = $row5['descripcion'];
             
             $sql6 = "select nomdepto from reu_municipios where coddepto=$departamento group by coddepto, nomdepto";
             $stmt6  = $pdo->query($sql6);
             $row6   = $stmt6->fetch(PDO::FETCH_ASSOC);
             $depto  = $row6['nomdepto'];
             
             $sql7   = "SELECT nommunicipio FROM reu_municipios where codmunicipio = $municipio and coddepto=$departamento";
	         $stmt7  = $pdo->query($sql7);
	         $row7   = $stmt7->fetch(PDO::FETCH_ASSOC);
             $nommun = $row7['nommunicipio'];
             
             $sql   = "SELECT descripcion from graerr_tipo_estudio_riesgo where id = $tipo_estudio_riesgo";
	         $stmt  = $pdo->query($sql);
	         $row   = $stmt->fetch(PDO::FETCH_ASSOC);
             $tipo_estudio = $row['descripcion'];
             
            ///////////    
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
                       <div class="col-sm-12" ALIGN="left">
                          <h3> <i class='fas fa-project-diagram' style='color:#2f79b9'></i>  Grupo de Recepción, Análisis, Evaluación del Riesgo y Recomendaciones - GRAERR </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <a href="graerrFormulario0.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
                        </div>                
                      </div>
                  </div>
                  <!--- FIN BARRA DE TITULO ----> 
                  
                  <div class="panel panel-info">
                 <div class="panel-heading">
                <div class="btn-group pull-right">        	     
                </div>
              <h4><i class="fa fa-keyboard-o" style='color:#2f79b9'></i> REMISION A SUBCOMISIÓN MTSP </h4>
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
                    <div class="container-fluid" style="margin-bottom:10px;">
                        <div class="row"  style="margin-top:10px;">
                          <p><b><i class='fas fa-book-open'></i> DATOS DE LA OT</b></p>
                        </div> <!-- row -->
                        
                        <div class="row" style="margin-top:10px;">
                            <div class="col-sm-2" align="left">
                                <b>Número de Registro:</b> 
                            </div>
                            <div class="col-sm-8" align="left">
                                <?=$s_registro?>  
                            </div>
                        </div> <!-- row -->
                        
                        <div class="row" style="margin-top:10px;">
                            <div class="col-sm-2" align="left">
                                 <b>Tipo de Estudio: </b>
                            </div>
                            <div class="col-sm-8" align="left">
                                 <?=$tipo_estudio?>
                            </div>
                        </div> <!-- row -->
                        
                        <div class="row" style="margin-top:10px;">
                            <div class="col-sm-2" align="left">
                                 <b>Número de Ot:</b>
                            </div>
                            <div class="col-sm-3" align="left">
                                 <?=$ot?>
                            </div>
                            
                            <div class="col-sm-2" align="left">
                                 <b>Fecha de Ot:</b>
                            </div>
                            <div class="col-sm-4" align="left">
                                 <?=$fecha_asignado_ot?>
                            </div>
                        </div> <!-- row -->
                        
                        <div class="row"  style="margin-top:10px;"><br>
                          <p><b><i class='fas fa-user-edit'></i> DATOS DEL PETICIONARIO</b></p>
                        </div> <!-- row -->
                        
                        <div class="row"  style="margin-top:10px;">
                           <div class="col-sm-2" align="left">
                              <b>Identificación: </b> 
                           </div>  
                           <div class="col-sm-8" align="left">
                              <?=$documento?>:  <b>No.</b> <?=$no_documento?>
                           </div>  
                        </div> <!-- row -->   
                        
                        <div class="row"  style="margin-top:10px;">
                           <div class="col-sm-2" align="left">
                               <b>Nombre: </b>
                           </div>
                           <div class="col-sm-8" align="left">
                               <?=$nombres_peticionario?> <?=$apellidos_peticionario?>
                           </div>
                        </div> <!-- row -->
                        
                        <div class="row"  style="margin-top:10px;">
                            <div class="col-sm-2" align="left">
                                <b>Población</b> 
                            </div>
                            <div class="col-sm-8" align="left">
                                <?=$subpob?>
                            </div>
                        </div> <!-- row -->    
                            
                        <div class="row"  style="margin-top:10px;">
                            <div class="col-sm-2" align="left">
                                 <b>Factor Diferencial</b>  <br>
                            </div>    
                            <div class="col-sm-8" align="left">
                                 <?=$fact_dif?>
                            </div>    
                        </div> <!-- row -->    
                        
                       
                        <div class="row"  style="margin-top:10px;">
                            <div class="col-sm-2" align="left">
                               <b>Departamento: </b> 
                            </div>
                            
                            <div class="col-sm-3" align="left">
                               <?=$depto?> 
                            </div>
                            
                            <div class="col-sm-2" align="left">
                               <b>Municipio:</b> 
                            </div>
                            
                            <div class="col-sm-4" align="left">
                               <?=$nommun?> 
                            </div>
                        </div> <!-- row -->
                        
                        <div class="row"  style="margin-top:10px;"><br>
                          <p><b><i class='fas fa-user-cog'></i> DATOS DEL ANALISTA</b></p>
                        </div> <!-- row -->
                        
                        <div class="row"  style="margin-top:10px;">
                            <div class="col-sm-6" align="center">
                               <b>Analista: </b> <br>
                               <?=$analista_riesgo?> 
                           </div>
                           <div class="col-sm-6" align="left">
                               <b>Recomendación Medidas Premesa: </b> <br>
                               <?=$rec_med_prem?> 
                           </div>
                        </div> <!-- row -->
                       
                        <div class="row">
                           <div class="col-sm-12" align="center">
                               <b>Recomendación Riesgo Premesa: </b> <br>
                               <?=$recomendacion_riesgo_premesa?>
                           </div>
                        </div> <!-- row -->       
                       
                       <div class="row"  style="margin-top:10px;">
                           <div class="col-sm-12" align="center">
                             <b>Observaciones / recomendaciones Adicionales: </b> <br>  
                             <textarea  style="text-transform:uppercase;" class="form-control" id="obsadicionales_graerr" name="obsadicionales_graerr" rows="3" <?=$obsadicionales_graerr?>>  </textarea> 
                           </div>
                        </div>   
                       
                       
                    </div> <!--- container -->
                </div> <!-- body -->
                
                <div class="modal-footer"> 
                   <div class="col-sm-11" align="center">  
                       <button type="submit" name='enviar' class="btn btn-md btn-success btn-lg" onclick='return confirmarEnvio()'><i class="fa fa-check-square-o"></i> REALIZAR REMISION A SUBCOMISIÓN MTSP</button>
                </div>	 
              </div>
              
             <div style="display:none">
              <input style="visibility:hidden" name= "registro" value="<?=$s_registro?>"/>
              <input style="visibility:hidden" name= "tipo_estudio_riesgo" value="<?=$tipo_estudio_riesgo?>"/>
              <input style="visibility:hidden" name= "ot "value="<?=$ot?>"/>
              <input style="visibility:hidden" name= "tipo_documento" value="<?=$tipo_documento?>"/>
              <input style="visibility:hidden" name= "no_documento" value="<?=$no_documento?>"/>
              <input style="visibility:hidden" name= "nombres_peticionario" value="<?=$nombres_peticionario?>"/>
              <input style="visibility:hidden" name= "apellidos_peticionario" value="<?=$apellidos_peticionario?>"/>
              <input style="visibility:hidden" name= "analista_riesgo" value="<?=$analista_riesgo?>"/>
              <input style="visibility:hidden" name= "recomendacion_riesgo_premesa" value="<?=$recomendacion_riesgo_premesa?>"/>
              <input style="visibility:hidden" name= "recomendacion_medidas_premesa" value="<?=$recomendacion_medidas_premesa?>"/>
              <input style="visibility:hidden" name= "departamento" value="<?=$departamento?>"/>
              <input style="visibility:hidden" name= "municipio" value="<?=$municipio?>"/>
              <input style="visibility:hidden" name= "no_de_contacto" value="<?=$no_de_contacto?>"/>
              <input style="visibility:hidden" name= "factor_diferencial" value="<?=$factor_diferencial?>"/>
              <input style="visibility:hidden" name= "subpoblacion" value="<?=$subpoblacion?>"/>
              
              <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
              <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
             </div>
                    
            </form>

  
  
  
        <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="js/jasny-bootstrap.min.js"></script>
    
    </body>
  </html>