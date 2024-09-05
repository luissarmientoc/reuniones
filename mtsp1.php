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
  $title="UNP | Anexo Mesa Técnic";    
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
             
          function datoCiiu() {
                 // Obtener el valor del select
                 var cod = document.getElementById("id_ciudad").value;
                 document.getElementById("municipio").value = cod;

                 // Obtener el texto del select
                 var combo = document.getElementById("id_ciudad");
                 var selected = combo.options[combo.selectedIndex].text;
                 document.getElementById("nommunicipio").value = selected;
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
        $sql = "select * from mt_anexotecnico where registro=$s_registro";
        $stmt = $pdo->query($sql);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
          
            $registro               = $row['registro'];
            $conteo_acta            = $row['conteo_acta']; 
            $conteo_porsesion       = $row['conteo_porsesion'];
            $tipo_estudio           = $row['tipo_estudio']; 
            $ot                     = $row['ot'];
            $tipo_documento         = $row['tipo_documento'];
            $no_documento           = $row['no_documento']; 
            $nombres_peticionario   = $row['nombres_peticionario']; 
            $apellidos_peticionario = $row['apellidos_peticionario']; 
            $analista_riesgo        = $row['analista_riesgo']; 
            $recomendacion_riesgo_premesa = $row['recomendacion_riesgo_premesa']; 
            $recomendacion_medidas_premesa = $row['recomendacion_medidas_premesa']; 
            $consenso               = $row['consenso']; 
            $orden                  = $row['orden']; 
            $temporalidad           = $row['temporalidad']; 
            $obs_temporalidad       = $row['obs_temporalidad']; 
            $departamento           = $row['departamento'];
            $municipio              = $row['municipio'];
            $subpoblacion           = $row['subpoblacion']; 
            $factor_diferencial     = $row['factor_diferencial']; 
            $no_de_contacto         = $row['no_de_contacto'];
            $motivacion             = $row['motivacion'];
            $obsadicionales_graerr  = $row['obsadicionales_graerr']; 
            $observaciones_smt      = $row['observaciones_smt'];
            $estado                 = $row['estado']; 
            $fecha_estado           = $row['fecha_estado'];
            $fecha_asignado_ot      = $row['fecha_asignado_ot']; 
            $tipo_ruta              = $row['tipo_ruta'];
      }
      
      
    //============================= CONSULTA EL graerr_tipo_documento
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_tipo_documento order by tipo_documento');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_tipo_documento .=" <option value=''>".'- Seleccione el tipo de documento -'."</option>";
      }
      if ($line['id']==$tipo_documento)
      {
        $combo_tipo_documento .=" <option value='".$line['id']."' selected>".$line['tipo_documento']." </option>"; 
      }
      $combo_tipo_documento .=" <option value='".$line['id']."'>".$line['tipo_documento']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_analista_riesgo
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_analista_riesgo order by nombre_analista');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_analista_riesgo .=" <option value=''>".'- Seleccione el analista de riesgo -'."</option>";
      }
      if ($line['id']==$analista_riesgo)
      {
        $combo_analista_riesgo .=" <option value='".$line['id']."' selected>".$line['nombre_analista']." </option>"; 
      }
      $combo_analista_riesgo .=" <option value='".$line['id']."'>".$line['nombre_analista']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_recomendacion_premesa
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_recomendacion_premesa order by id');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_recomendacion_premesa .=" <option value=''>".'- Seleccione la recomendacion de premesa -'."</option>";
      }
      if ($line['id']==$recomendacion_medidas_premesa)
      {
        $combo_recomendacion_premesa .=" <option value='".$line['id']."' selected>".$line['descripcion']." </option>"; 
      }
      $combo_recomendacion_premesa .=" <option value='".$line['id']."'>".$line['descripcion']."</option>"; 
      $i++; 
    }
    
    
    //============================= CONSULTA LOS DEPARTAMENTOS
    //============================================================================ 
    $stmt = $pdo->query('SELECT coddepto, nomdepto  FROM reu_municipios GROUP BY coddepto, nomdepto;');
  
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboDepto .=" <option value=''>".'- Seleccione el departamento -'."</option>";
      }
      if ($line['coddepto']==$departamento)
      {
        $comboDepto .=" <option value='".$line['coddepto']."' selected>".$line['nomdepto']." </option>"; 
      }
      $comboDepto .=" <option value='".$line['coddepto']."'>".$line['nomdepto']."</option>"; 
      $i++; 
    }
   
    //TOMA EL NOMBRE DEL MUNICIPIO
    //trae nombre del municipio
    if ($municipio>0)
    {
	  $sqlDep       = "SELECT nommunicipio FROM reu_municipios where codmunicipio ='$municipio' and coddepto=$departamento";
	  $stmtDep      = $pdo->query($sqlDep);
	  $rowDep       = $stmtDep->fetch(PDO::FETCH_ASSOC);
      $nommunicipio = $rowDep['nommunicipio'];
    }
    
    //============================= CONSULTA EL graerr_poblacion
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_poblacion order by id');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_subpoblacion .=" <option value=''>".'- Seleccione la subpoblacion -'."</option>";
      }
      if ($line['id']==$subpoblacion)
      {
        $combo_subpoblacion .=" <option value='".$line['id']."' selected>".$line['descripcion']." </option>"; 
      }
      $combo_subpoblacion .=" <option value='".$line['id']."'>".$line['descripcion']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_factor_diferencial
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_factor_diferencial order by factor_diferencial');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_factor_diferencial .=" <option value=''>".'- Seleccione el factor diferencial -'."</option>";
      }
      if ($line['id']==$factor_diferencial)
      {
        $combo_factor_diferencial .=" <option value='".$line['id']."' selected>".$line['factor_diferencial']." </option>"; 
      }
      $combo_factor_diferencial .=" <option value='".$line['id']."'>".$line['factor_diferencial']."</option>"; 
      $i++; 
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
                       <div class="col-sm-8" ALIGN="left">
                          <h3> <i class='fas fa-project-diagram' style='color:#2f79b9'></i>  Subcomisión Mesa Técnica </h3>
                       </div> 
                       
                       <div class="col-sm-4" align="right">  					  			 
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
              <h4><i class="fa fa-keyboard-o" style='color:#2f79b9'></i> ANALISIS SUBCOMISIÓN MTSP</h4>
            </div>
            
            <?php  
                if ($s_tocoBoton=="S")
                {
                   $active="disabled";     
            ?> 
                   <div class="alert alert-success" align="center"><?=$mensaje?></div>
            <?php 
                }
            ?>   
            
            <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="panel-body">	
                    <div class="container-fluid" style="margin-bottom:10px;">
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-4" align="left">
                               <label for="conteo_acta">Conteo por acta:</label>
                               <input type="text" class="form-control" id="conteo_acta" name="conteo_acta"  value="<?=$conteo_acta?>" required>
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="conteo_porsesion">Conteo por sesión:</label>
                               <input type="text" class="form-control" id="conteo_porsesion" name="conteo_porsesion"  value="<?=$conteo_porsesion?>"  >
                           </div>
                            
                        </div> <!-- row -->    
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-4" align="left">
                               <label for="conteo_acta">Tipo de Estudio:</label>
                               <input type="text" class="form-control" id="tipo_estudio" name="tipo_estudio"  value="<?=$tipo_estudio?>" required  >
                            </div>
                           
                            <div class="col-sm-4" align="left">
                               <label for="$ot">OT:</label>
                               <input type="text" class="form-control" id="ot" name="ot"  value="<?=$ot?>" required  >
                            </div>
                           
                            <div class="col-sm-4" align="left">
                               <label for="fecha_asignado_ot">Fecha de Asgnación de OT:</label>
                               <input type="text" class="form-control" id="fecha_asignado_ot" name="fecha_asignado_ot"  value="<?=$fecha_asignado_ot?>" required  >
                            </div>
                        </div> <!-- row -->    
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-3" align="left">
                               <label for="ot">Tipo de Documento:</label>
                               <select <?=$active?> required class="form-control" name="tipo_documento" required>
                                  <?php echo $combo_tipo_documento; ?>
                               </select> 
                            </div>
                    
                            <div class="col-sm-3" align="left">
                               <label for="no_documento">Número de Documento:</label>
                               <input type="text" class="form-control" id="no_documento" name="no_documento"  value="<?=$no_documento?>" required  >
                            </div>
                            
                            <div class="col-sm-3" align="left">
                               <label for="nombres_peticionario">Nombres del Peticionario:</label>
                               <input type="text" class="form-control" id="nombres_peticionario" name="nombres_peticionario"  value="<?=$nombres_peticionario?>" required  >
                            </div>
                            
                             <div class="col-sm-3" align="left">
                               <label for="apellidos_peticionario">Apellidos del Peticionario:</label>
                               <input type="text" class="form-control" id="apellidos_peticionario" name="apellidos_peticionario"  value="<?=$apellidos_peticionario?>" required  >
                            </div>
                        </div> <!-- row -->    
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-6" align="left">
                               <label for="analista_riesgo">Analista de Riesgo:</label>
                               <select <?=$active?> required class="form-control" name="analista_riesgo" required>
                                  <?php echo $combo_analista_riesgo; ?>
                               </select>
                            </div>
                            
                            <div class="col-sm-6" align="left">
                               <label for="analista_riesgo">Recomendacion Medidas de Premesa:</label>
                               <select <?=$active?>  class="form-control" name="recomendacion_medidas_premesa" required>
                                  <?php echo $combo_recomendacion_premesa; ?>
                               </select>
                            </div>
                        </div> <!-- row -->        
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-12" align="left">
                               <label for="recomendacion_riesgo_premesa">Recomendacion Riesgo de Premesa:</label><br>
                               <textarea  style="text-transform:uppercase;" class="form-recomendacion_riesgo_premesa" id="recomendacion_riesgo_premesa" name="recomendacion_riesgo_premesa" rows="3"> <?=$recomendacion_riesgo_premesa?></textarea>
                            </div>
                        </div> <!-- row -->        
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-3" align="left">
                               <label for="consenso">Consenso:</label>
                               <input type="text" class="form-control" id="consenso" name="consenso"  value="<?=$consenso?>" required >
                            </div>
                            
                            <div class="col-sm-3" align="left">
                               <label for="orden">Orden:</label>
                               <input type="text" class="form-control" id="orden" name="orden"  value="<?=$orden?>" required >
                            </div>
                            
                            <div class="col-sm-3" align="left">
                               <label for="orden">Temporalidad:</label>
                               <input type="text" class="form-control" id="temporalidad" name="temporalidad"  value="<?=$temporalidad?>" required  >
                            </div>
                            
                            <div class="col-sm-3" align="left">
                               <label for="obs_temporalidad">Observaciones Temporalidad:</label>
                               <input type="text" class="form-control" id="obs_temporalidad" name="obs_temporalidad"  value="<?=$obs_temporalidad?>" required  >
                            </div>
                        </div> <!-- row -->   
                        
                        <div class="row" style="margin-top:5px;">
                            
                            <div class="col-sm-4" align="left"> 
                                <label for="departamento">DEPARTAMENTO</label>
                                <select class="form-control" id="departamento" name="departamento" onchange="loadCiudadD(this.value)">
                                <!--<select required class="form-control" name="departments" id="departments" onchange="loadCities(this.value)">-->
                                        <?php echo $comboDepto; ?>
                                </select>
                             <!-- <input type="text" class="form-control" id="departamento" name="departamento"required>-->
                             <br><br>
                          </div>
                          
                          <div class="col-sm-4">
                               <b>Municipio:</b>  
                               <div id="myDiv"> </div> 
                          </div>
                           
                           
                          <div class="col-sm-4">
                              <b>Municipio: </b>     
                               <input style ="display:none;" class="form-control" type="text" readonly value="<?=$municipio?>" name="municipio" id="municipio">                         
                               <input type="text" class="form-control" id="nommunicipio" name="nommunicipio" value="<?=$nommunicipio?> " placeholder="Municipio" readonly><br>  
                          </div>
                        </div><!--- row --->     
                         
                         <div class="row" style="margin-top:5px;">
                            <div class="col-sm-3" align="left">
                               <label for="direccion">Dirección:</label>
                               <input type="text" class="form-control" id="direccion" name="direccion"  value="<?=$direccion?>" required >
                            </div>
                            
                            <div class="col-sm-3" align="left">
                               <label for="no_de_contacto">Contacto:</label>
                               <input type="text" class="form-control" id="no_de_contacto" name="no_de_contacto"  value="<?=$no_de_contacto?>" required >
                            </div>
                            
                        </div> <!-- row -->       
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-3" align="left">
                               <label for="subpoblacion">Poblacion:</label>
                               <select <?=$active?> required class="form-control" name="subpoblacion" required>
                                 <?php echo $combo_subpoblacion; ?>
                              </select>
                            </div>
                            
                            <div class="col-sm-3" align="left">
                               <label for="factor_diferencial">Factor Diferencial:</label>
                               <select <?=$active?> required class="form-control" name="factor_diferencial">
                                  <?php echo $combo_factor_diferencial; ?>
                               </select>
                            </div>
                        </div> <!-- row -->       
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-3" align="left">
                               <label for="motivacion">Motivacion:</label>
                               <input type="text" class="form-control" id="motivacion" name="motivacion"  value="<?=$motivacion?>" required >
                            </div>
                            
                            <div class="col-sm-9" align="left">
                               <label for="motivacion">Observaciones Adicionales Graerr:</label>
                               <textarea  style="text-transform:uppercase;" class="form-obsadicionales_graerr" id="obsadicionales_graerr" name="obsadicionales_graerr" rows="3"> <?=$obsadicionales_graerr?></textarea>
                            </div>
                        </div> <!-- row -->     
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-12" align="left">
                               <label for="observaciones_smt">Observaciones Adicionales MTSP:</label>
                               <textarea  style="text-transform:uppercase;" class="form-observaciones_smt" id="observaciones_smt" name="observaciones_smt" rows="3"> <?=$observaciones_smt?> </textarea>
                            </div> 
                        </div> <!-- row -->     
                       
                    </div> <!-- container -->    
                </div> <!-- panel-body -->
                
                <div class="modal-footer"> 
                    <div class="col-sm-11" align="center">  					  			 
                     <button type="submit" name='grabar' class="btn btn-md btn-success btn-lg"><i class="glyphicon glyphicon-refresh"></i> <?=$boton?> </button>
                    </div>	 
                </div>
         
                <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
                
            </form>    
   
             <!--- complemento -->
              <?php
               include("complemento.html");             
              ?>
              <!--- fin complemento -->
       <script type="text/javascript" src="buscarCiudad.js"></script>
      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="js/jasny-bootstrap.min.js"></script>    
   </body>
</html>  