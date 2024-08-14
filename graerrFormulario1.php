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
  $title="UNP | GRAERR Formulario";    
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
    
    $s_registro   = $partir[0];
    $tipAccion            = $partir[1];
    
    
    if ( $s_registro != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA  
      $titulo = "MODIFICAR REGISTRO";
      $s_existe = 1;
      $boton  = "Actualizar";
    
      $sql = "select * from graerr_formulario where registro=$registro";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      
             $registro = $row['registro'];
             $vigencia = $row['vigencia'];
             $fecha_recepcion_unp = $row['fecha_recepcion_unp'];
             $fecha_recepcion_graerr = $row['fecha_recepcion_graerr'];
             $fecha_carta_solicitante = $row['fecha_carta_solicitante'];
             $no_mem_ext = $row['no_mem_ext'];
             $otras_entradas_sigob = $row['otras_entradas_sigob'];
             $no_folios = $row['no_folios'];
             $entidad_persona_solicitante = $row['entidad_persona_solicitante'];
             $destinatario = $row['destinatario'];
             $tipo_documento = $row['tipo_documento'];
             $no_documento = $row['no_documento'];
             $nombres_apellidos_peticionario = $row['nombres_apellidos_peticionario'];
             $seudonimo = $row['seudonimo'];
             $tipo_ruta = $row['tipo_ruta'];
             $descripcion_colectivo = $row['descripcion_colectivo'];
             $nombre_colectivo = $row['nombre_colectivo'];
             $no_personas_evaluar = $row['no_personas_evaluar'];
             $genero = $row['genero'];
             $grupo_etnico = $row['grupo_etnico'];
             $correo_electronico = $row['correo_electronico'];
             $no_de_contacto = $row['no_de_contacto'];
             $otros_numeros_contacto = $row['otros_numeros_contacto'];
             $direccion = $row['direccion'];
             $departamento = $row['departamento'];
             $municipio = $row['municipio'];
             $corregimiento_vereda = $row['corregimiento_vereda'];
             $autoriza_envio_info = $row['autoriza_envio_info'];
             $fecha_asignacion_analisis = $row['fecha_asignacion_analisis'];
             $analista_solicitudes = $row['analista_solicitudes'];
             $medidas_preventivas = $row['medidas_preventivas'];
             $estado_solicitud = $row['estado_solicitud'];
             $fecha_asignado_ot = $row['fecha_asignado_ot'];
             $fecha_reasignacion_ot = $row['fecha_reasignacion_ot'];
             $estado_ot = $row['estado_ot'];
             $ot = $row['ot'];
             $analista_riesgo = $row['analista_riesgo'];
             $analista_riesgo_dos = $row['analista_riesgo_dos'];
             $analista_calidad = $row['analista_calidad'];
             $subpoblacion = $row['subpoblacion'];
             $tipo_estudio_riesgo = $row['tipo_estudio_riesgo'];
             $tramite_emergencia = $row['tramite_emergencia'];
             $fecha_tramite_emergencia = $row['fecha_tramite_emergencia'];
             $ingreso_calidad = $row['ingreso_calidad'];
             $fecha_aprobacion_calidad = $row['fecha_aprobacion_calidad'];
             $fecha_presentacion_premesa = $row['fecha_presentacion_premesa'];
             $recomendacion_riesgo_premesa = $row['recomendacion_riesgo_premesa'];
             $recomendacion_medidas_premesa = $row['recomendacion_medidas_premesa'];
             $observaciones_premesa = $row['observaciones_premesa'];
             $tiempo_gestion_graerr = $row['tiempo_gestion_graerr'];
             $remision_mesa_tecnica = $row['remision_mesa_tecnica'];
             $mes_remision = $row['mes_remision'];
             $ano_remision = $row['ano_remision'];
             $observaciones = $row['observaciones'];
             $seguimiento = $row['seguimiento'];
             $factor_diferencial = $row['factor_diferencial'];
             $reporte_936 = $row['reporte_936'];
             $verificacion = $row['verificacion'];
             $otros = $row['otros'];
             $dev_traslados_poblacional = $row['dev_traslados_poblacional'];
    }  
    else
    {
      $titulo = "NUEVO REGISTRO GRAERR";
      $s_existe = 0;
      $boton="Grabar";
    }  
    
    
   if(isset($_POST['grabar']))
   {   
     $s_idGrupoInterno = $_POST['idGrupoInterno'];
     $s_grupoInterno   = $_POST['grupoInterno'];
     
     $s_grupoInterno = strtoupper($s_grupoInterno);
   
     $s_existe         = $_POST['existe'];
     $s_yaGrabo        = $_POST['yaGrabo'];
    
     date_default_timezone_set('America/Bogota');
     //$s_fecha  = date("Y-m-d",time());
     //$s_fecha  = date("Y/m/d H:i:s");
     $date_added=date("Y-m-d H:i:s");
     
      ///MODIFICA
      if ($s_existe == "1")  
      {
        $sql = "UPDATE reu_grupos_internos SET grupointerno = :grupointerno WHERE idgrupointerno = :idgrupointerno";
        $stmt = $pdo->prepare($sql);
    
        // Vincular parámetros
        $stmt->bindParam(':grupointerno', $s_grupoInterno, PDO::PARAM_STR);
        $stmt->bindParam(':idgrupointerno', $s_idGrupoInterno, PDO::PARAM_INT);
    
        // Ejecutar la consulta
        $stmt->execute();
        
        $mensaje=" <b>Atención!</b> Actualización exitosa";
      }  
      
      ///ADICIONA
      if ($s_existe == "0")
      {
        $sql = "SELECT MAX(idgrupointerno) AS maximo FROM reu_grupos_internos";
        $stmt = $pdo->query($sql);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $s_maximo = $row['maximo'];
        
        $s_idGrupoInterno     = $s_maximo+1;
        
        // Inserción de datos
        $stmt = $pdo->prepare('INSERT INTO reu_grupos_internos (idgrupointerno, grupointerno) VALUES (?, ?)');
        $stmt->execute([$s_idGrupoInterno, $s_grupoInterno]);
        
        $mensaje=" <b>Atención!</b> Grabación exitosa ¡";
        
        $s_existe ="1";
      }   
       
      $s_tocoBoton = "S";  
          
   }//grabar
   
   
   ////////////////////////////////////
  ////// DESPLEGABLES //////////////////
  ////////////////////////////////////
  
    //============================= CONSULTA EL graerr_analista_calidad
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_analista_calidad order by nombre');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_analista_calidad .=" <option value=''>".'- Seleccione el analista de calidad -'."</option>";
      }
      if ($line['id']==$analista_calidad)
      {
        $combo_analista_calidad .=" <option value='".$line['id']."' selected>".$line['nombre']." </option>"; 
      }
      $combo_analista_calidad .=" <option value='".$line['id']."'>".$line['nombre']."</option>"; 
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
   
    //============================= CONSULTA EL graerr_analista_solicitudes
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_analista_solicitudes order by nombre_analista');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_analista_solicitudes .=" <option value=''>".'- Seleccione el analista de solicitudes -'."</option>";
      }
      if ($line['id']==$analista_solicitudes)
      {
        $combo_analista_solicitudes .=" <option value='".$line['id']."' selected>".$line['nombre_analista']." </option>"; 
      }
      $combo_analista_solicitudes .=" <option value='".$line['id']."'>".$line['nombre_analista']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_asignado_por
    //============================================================================ 
    //$stmt = $pdo->query('select * from graerr_asignado_por order by nombre');
    //$i=0;
    
    //============================= CONSULTA EL graerr_autoriza_correo
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_autoriza_correo order by autoriza_correo');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_autoriza_correo .=" <option value=''>".'- Seleccione quien autoriza el correo -'."</option>";
      }
      if ($line['id']==$autoriza_envio_info)
      {
        $combo_autoriza_correo .=" <option value='".$line['id']."' selected>".$line['autoriza_correo']." </option>"; 
      }
      $combo_autoriza_correo .=" <option value='".$line['id']."'>".$line['autoriza_correo']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_desc_colectivo
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_desc_colectivo order by descripcion');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_desc_colectivo .=" <option value=''>".'- Seleccione descripción del colectivo -'."</option>";
      }
      if ($line['id']==$descripcion_colectivo)
      {
        $combo_desc_colectivo .=" <option value='".$line['id']."' selected>".$line['descripcion']." </option>"; 
      }
      $combo_desc_colectivo .=" <option value='".$line['id']."'>".$line['descripcion']."</option>"; 
      $i++; 
    }
   
    //============================= CONSULTA EL graerr_estado_asignacion
    //============================================================================ 
    //$stmt = $pdo->query('select * from graerr_estado_asignacion order by estado');
    //$i=0;
    
    
    //============================= CONSULTA EL graerr_estado_ot
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_estado_ot order by estado');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_estado_ot .=" <option value=''>".'- Seleccione el estado de la OT -'."</option>";
      }
      if ($line['id']==$estado_ot)
      {
        $combo_estado_ot .=" <option value='".$line['id']."' selected>".$line['estado']." </option>"; 
      }
      $combo_estado_ot .=" <option value='".$line['id']."'>".$line['estado']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_estado_solicitud
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_estado_solicitud order by estado_solicitud');
    $i=0;
     while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_estado_solicitud .=" <option value=''>".'- Seleccione el estado de la solicitud -'."</option>";
      }
      if ($line['id']==$estado_solicitud)
      {
        $combo_estado_solicitud .=" <option value='".$line['id']."' selected>".$line['estado_solicitud']." </option>"; 
      }
      $combo_estado_solicitud .=" <option value='".$line['id']."'>".$line['estado_solicitud']."</option>"; 
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
      if ($line['id']==$subpoblacion)
      {
        $combo_factor_diferencial .=" <option value='".$line['id']."' selected>".$line['factor_diferencial']." </option>"; 
      }
      $combo_factor_diferencial .=" <option value='".$line['id']."'>".$line['factor_diferencial']."</option>"; 
      $i++; 
    }
   
    //============================= CONSULTA EL graerr_genero
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_genero order by genero');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_genero .=" <option value=''>".'- Seleccione el genero -'."</option>";
      }
      if ($line['id']==$genero)
      {
        $combo_genero .=" <option value='".$line['id']."' selected>".$line['genero']." </option>"; 
      }
      $combo_genero .=" <option value='".$line['id']."'>".$line['genero']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_grupo_etnico
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_grupo_etnico order by grupo_etnico');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_grupo_etnico .=" <option value=''>".'- Seleccione el grupo étnico -'."</option>";
      }
      if ($line['id']==$grupo_etnico)
      {
        $combo_grupo_etnico .=" <option value='".$line['id']."' selected>".$line['grupo_etnico']." </option>"; 
      }
      $combo_grupo_etnico .=" <option value='".$line['id']."'>".$line['grupo_etnico']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_medidas_preventivas
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_medidas_preventivas order by medida_preventiva');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_medidas_preventivas .=" <option value=''>".'- Seleccione la medida preventiva -'."</option>";
      }
      if ($line['id']==$medidas_preventivas)
      {
        $combo_medidas_preventivas .=" <option value='".$line['id']."' selected>".$line['medida_preventiva']." </option>"; 
      }
      $combo_medidas_preventivas .=" <option value='".$line['id']."'>".$line['medida_preventiva']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_poblacion
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_poblacion order by descripcion');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_poblacion .=" <option value=''>".'- Seleccione la población -'."</option>";
      }
      if ($line['id']==$poblacion)
      {
        $combo_poblacion .=" <option value='".$line['id']."' selected>".$line['descripcion']." </option>"; 
      }
      $combo_poblacion .=" <option value='".$line['id']."'>".$line['descripcion']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_recomendacion_premesa
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_recomendacion_premesa order by descripcion');
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
    
    
    //============================= CONSULTA EL graerr_seguimiento
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_seguimiento order by descripcion');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_seguimiento .=" <option value=''>".'- Seleccione el seguimiento -'."</option>";
      }
      if ($line['id']==$seguimiento)
      {
        $combo_seguimiento .=" <option value='".$line['id']."' selected>".$line['descripcion']." </option>"; 
      }
      $combo_seguimiento .=" <option value='".$line['id']."'>".$line['descripcion']."</option>"; 
      $i++; 
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
    
    
    //============================= CONSULTA EL graerr_tipo_estudio_riesgo
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_tipo_estudio_riesgo order by descripcion');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_tipo_estudio_riesgo .=" <option value=''>".'- Seleccione el tipo de estudio de riesgo -'."</option>";
      }
      if ($line['id']==$tipo_estudio_riesgo)
      {
        $combo_tipo_estudio_riesgo .=" <option value='".$line['id']."' selected>".$line['descripcion']." </option>"; 
      }
      $combo_tipo_estudio_riesgo .=" <option value='".$line['id']."'>".$line['descripcion']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_tipo_ruta
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_tipo_ruta order by tipo_ruta');
    $i=0;
     while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_tipo_ruta .=" <option value=''>".'- Seleccione el tipo de ruta -'."</option>";
      }
      if ($line['id']==$tipo_ruta)
      {
        $combo_tipo_ruta .=" <option value='".$line['id']."' selected>".$line['tipo_ruta']." </option>"; 
      }
      $combo_tipo_ruta .=" <option value='".$line['id']."'>".$line['tipo_ruta']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA EL graerr_vigencia
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_vigencia order by ano');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_vigencia .=" <option value=''>".'- Seleccione ls vigencia -'."</option>";
      }
      if ($line['id']==$vigencia)
      {
        $combo_vigencia .=" <option value='".$line['id']."' selected>".$line['ano']." </option>"; 
      }
     // $combo_vigencia .=" <option value='".$line['id']."'>".$line['tipo_ruta']."</ano>"; 
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
                       <div class="col-sm-6" ALIGN="left">
                          <h3> <i class='fas fa-project-diagram' style='color:#2f79b9'></i>  Grupo de Recepción, Análisis, Evaluación del Riesgo y Recomendaciones - GRAERR </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <a href="grupos0.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
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
                   <div class="container" style="margin-bottom:10px;">
                       <!--------------------------------------------------------- 
                       ----------------------DATOS DEL TRAMITE--------------------
                       ---------------------------------------------------------->
                            <!--D8544F-->
                       <div class="row"  style="background-color:#337AB8; color:#fff;" >
                           <div class="col-sm-12" align="center">
                               <h4>DATOS DEL TRAMITE</h4>
                           </div>
                       </div>
                       
                       <div class="row" style="margin-top:5px;">
                           <div class="col-sm-3" align="left">
                               <label for="registro">REGISTRO</label>
                               <input type="text" class="form-control" id="registro" name="registro"  value="<?=$registro?>"required>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                               <label for="vigencia">VIGENCIA</label>
                               <!--<input type="text" class="form-control" id="vigencia" name="vigencia" value="<?=$vigencia?>"required>-->
                                <select <?=$active?> required class="form-control" name="vigencia">
                                  <?php echo $combo_vigencia; ?>
                                </select>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                               <label for="fecha_recepcion_unp">FECHA DE RECEPCION EN LA UNP</label>
                               <input type="date" class="form-control" id="fecha_recepcion_unp" name="fecha_recepcion_unp"  value="<?=$fecha_recepcion_unp?>" required>
                           </div>
                          
                            <div class="col-sm-3" align="left">
                               <label for="fecha_recepcion_graerr">FECHA RECEPCION GRAERR</label>
                               <input type="date" class="form-control" id="fecha_recepcion_graerr" name="fecha_recepcion_graerr"  value="<?=$fecha_recepcion_graerr?>" required>
                            </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">
                           <div class="col-sm-3" align="left">
                               <label for="fecha_carta_solicitante">FECHA DE CARTA SOLICITANTE</label>
                               <input type="date" class="form-control" id="fecha_carta_solicitante" name="fecha_carta_solicitante"  value="<?=$fecha_carta_solicitante?>" required>
                           </div>
                           
                           <div  class="col-sm-3" align="left">
                               <label for="no_mem_ext">No MEM y/o EXT</label>
                               <input type="text" class="form-control" id="no_mem_ext" name="no_mem_ext"  value="<?=$no_mem_ext?>" required>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                                <label for="otras_entradas_sigob">OTRAS ENTRADAS SIGOB</label>
                                <input type="text" class="form-control" id="otras_entradas_sigob" name="otras_entradas_sigob"  value="<?=$otras_entradas_sigob?>">
                            </div>
                            
                            <div class="col-sm-3" align="left">
                                <label for="no_folios">No FOLIOS</label>
                                <input type="text" class="form-control" id="no_folios" name="no_folios"  value="<?=$no_folios?>" required>
                            </div>
                       </div> <!--row-->    
                       
                       <div class="row" style="margin-top:5px;">    
                            <div class="col-sm-6" align="left">
                                <label for="entidad_persona_solicitante">ENTIDAD/PERSONA SOLICITANTE</label>
                                <input type="text" class="form-control" id="entidad_persona_solicitante" name="entidad_persona_solicitante"  value="<?=$entidad_persona_solicitante?>" required>
                            </div>
                            
                            <div class="col-sm-6" align="left">
                                <label for="destinatario">DESTINATARIO</label>
                                <input type="text" class="form-control" id="destinatario" name="destinatario"  value="<?=$destinatario?>" required>
                            </div>
                       </div> <!--row-->
                    </div> <!--container-->
                    
                    <div class="container">   
                       <!--------------------------------------------------------- 
                       -----------DATOS DEL BENEFICIARIO O SOLICITANTE------------
                       ---------------------------------------------------------->
                       <div class="row" style="background-color:#5CC0DE; color:#fff;">
                           <div class="col-sm-12" align="center">
                               <h4>DATOS DEL BENEFICIARIO O SOLICITANTE</h4>
                           </div>
                       </div>
                       
                       <div class="row" style="margin-top:5px;">   
                           <div class="col-sm-4" align="left">
                               <label for="tipo_documento">TIPO DE DOCUMENTO</label>
                               <!--<input type="text" class="form-control" id="tipo_documento" name="tipo_documento"  value="<?=$tipo_documento?>" required>-->
                               <select <?=$active?> required class="form-control" name="tipo_documento">
                                  <?php echo $combo_tipo_documento; ?>
                               </select> 
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="no_documento">No DE DOCUMENTO</label>
                               <input type="text" class="form-control" id="no_documento" name="no_documento"  value="<?=$no_documento?>" required>
                           </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">   
                           <div class="col-sm-4" align="left">
                               <label style="font-size:12px;" for="nombres_apellidos_peticionario">NOMBRES PETICIONARIO O BENEFICIARIO</label>
                               <input type="text" class="form-control" id="nombres_apellidos_peticionario" name="nombres_apellidos_peticionario"  value="<?=$nombres_apellidos_peticionario?>" required>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label style="font-size:12px;" for="nombres_apellidos_peticionario">APELLIDOS PETICIONARIO O BENEFICIARIO</label>
                               <input type="text" class="form-control" id="nombres_apellidos_peticionario" name="nombres_apellidos_peticionario"  value="<?=$nombres_apellidos_peticionario?>" required>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="seudonimo">SEUDONIMO</label>
                               <input type="text" class="form-control" id="seudonimo" name="seudonimo"  value="<?=$seudonimo?>">
                           </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">   
                          <div class="col-sm-4" align="left">
                              <label for="tipo_ruta">TIPO DE RUTA</label>
                              <!--<input type="text" class="form-control" id="tipo_ruta" name="tipo_ruta"  value="<?=$tipo_ruta?>">-->
                               <select <?=$active?> required class="form-control" name="tipo_ruta">
                                 <?php echo $combo_tipo_ruta; ?>
                               </select>
                          </div>
                          
                          <div class="col-sm-4" align="left">
                              <label for="descripcion_colectivo">DESCRIPCION DEL COLECTIVO</label>
                              <input type="text" class="form-control" id="descripcion_colectivo" name="descripcion_colectivo"  value="<?=$descripcion_colectivo?>">
                          </div>
                          
                          <div class="col-sm-4" align="left">
                              <label for="nombre_colectivo">NOMBRE COLECTIVO</label>
                              <input type="text" class="form-control" id="nombre_colectivo" name="nombre_colectivo"  value="<?=$nombre_colectivo?>">
                          </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">   
                           <div class="col-sm-4" align="left">
                               <label for="no_personas_evaluar">No PERSONAS A EVALUAR</label>
                               <input type="number" class="form-control" id="no_personas_evaluar" name="no_personas_evaluar"  value="<?=$no_personas_evaluar?>" required>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="genero">GENERO</label>
                               <!--<input type="text" class="form-control" id="genero" name="genero"  value="<?=$genero?>">-->
                               <select <?=$active?> required class="form-control" name="genero">
                                  <?php echo $combo_genero; ?>
                               </select>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="grupo_etnico">GRUPO ETNICO</label>
                               <!--<input type="text" class="form-control" id="grupo_etnico" name="grupo_etnico"  value="<?=$grupo_etnico?>">-->
                               <select <?=$active?> required class="form-control" name="grupo_etnico">
                                  <?php echo $combo_grupo_etnico; ?>
                               </select>
                           </div>
                       </div> <!--row-->
                        
                       <div class="row" style="margin-top:5px;">                          
                          <div class="col-sm-4" align="left"> 
                              <label for="correo_electronico">CORREO ELECTRONICO</label>
                              <input type="email" class="form-control" id="correo_electronico" name="correo_electronico"   value="<?=$correo_electronico?>"required>
                          </div> 
                          <div class="col-sm-4" align="left">
                              <label for="no_contacto">No DE CONTACTO</label>
                              <input type="text" class="form-control" id="no_contacto" name="no_contacto"  value="<?=$no_contacto?>" required>
                          </div>
                          <div class="col-sm-4" align="left">
                              <label for="otros_numeros_contacto">OTROS NUMEROS DE CONTACTO</label>
                              <input type="text" class="form-control" id="otros_numeros_contacto" name="otros_numeros_contacto"  value="<?=$otros_numeros_contacto?>">
                          </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">  
                           <div class="col-sm-4" align="left">  
                              <label for="direccion">DIRECCION</label>
                              <input type="text" class="form-control" id="direccion" name="direccion"  value="<?=$direccion?>" required>
                          </div>
                          <div class="col-sm-4" align="left">
                              <label for="departamento">DEPARTAMENTO</label>
                              <input type="text" class="form-control" id="departamento" name="departamento"  value="<?=$departamento?>" required>
                          </div>
                          <div class="col-sm-4" align="left">
                              <label for="municipio">MUNICIPIO</label>
                              <input type="text" class="form-control" id="municipio" name="municipio"  value="<?=$municipio?>" required>
                          </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">  
                          <div class="col-sm-4" align="left">
                              <label for="corregimiento_vereda">CORREGIMIENTO O VEREDA</label>
                              <input type="text" class="form-control" id="corregimiento_vereda" name="corregimiento_vereda" value="<?=$corregimiento_vereda?>" required>
                          </div>
                       </div> <!--row-->
                       
                    </div> <!--container-->
                    
                    <div class="container" style="margin-bottom:10px;">
                       <!--------------------------------------------------------- 
                       ---------------------------ASIGNACIÓN----------------------
                       ---------------------------------------------------------->
                       <div class="row"  style="background-color:#D9EDF7; color:#2f79b9;" >
                           <div class="col-sm-12" align="center">
                               <h4>ASIGNACIÓN</h4>
                           </div>
                       </div>
                    </div> <!--container-->
                    
                    <div class="container" style="margin-bottom:10px;">
                       <!--------------------------------------------------------- 
                       ---------------------------PREMESA Y SUBCOMISIÓN----------------------
                       ---------------------------------------------------------->
                       <div class="row" style="background-color:#5CB85C; color:#fff;" >
                           <div class="col-sm-12" align="center">
                               <h4>PREMESA Y SUBCOMISIÓN</h4>
                           </div>
                       </div>
                    </div> <!--container-->
                    
                    
                    <div class="container" style="margin-bottom:10px;">
                       <!--------------------------------------------------------- 
                       ---------------------------ASIGNACIÓN----------------------
                       ---------------------------------------------------------->
                       <div class="row" style="background-color:#5CB85C; color:#fff;" >
                           <div class="col-sm-10" align="center">
                               <h4>PREMESA Y SUBCOMISIÓN</h4>
                           </div>
                       </div>
                    </div> <!--container-->
                    
                    <hr>
                   
                 <div class="container mt-5">
        <h1>Formulario de Registro Graerr</h1>
        <form action="procesar_formulario.php" method="post">
             
             
            <div class="form-row">
                 
                
            </div>
             
            <div class="form-row">
                
            </div>
            <div class="form-row">
                
            </div>
            <div class="form-row">
                
            </div>
            <div class="form-row">
                 
                 
            </div>
            <div class="form-row">
                
                <div class="form-group col-md-6">
                    <label for="autoriza_envio_info">AUTORIZA ENVIO DE INFO POR CORREO</label>
                    <select class="form-control" id="autoriza_envio_info" name="autoriza_envio_info" value="<?=$autoriza_envio_info?>">
                        <option value="si">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fecha_asignacion_analisis">FECHA ASIGNACION ANALISIS PRELIMINAR</label>
                    <input type="date" class="form-control" id="fecha_asignacion_analisis" name="fecha_asignacion_analisis" value="<?=$fecha_asignacion_analisis?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="analista_solicitudes">ANALISTA DE SOLICITUDES</label>
                    
                    <select <?=$active?> required class="form-control" name="analista_solicitudes">
                       <?php echo $combo_analista_solicitudes; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="medidas_preventivas">MEDIDAS PREVENTIVAS</label>
                    <!--<input type="text" class="form-control" id="medidas_preventivas" name="medidas_preventivas" value="<?=$medidas_preventivas?>">-->
                    <select <?=$active?> required class="form-control" name="medidas_preventivas">
                       <?php echo $combo_medidas_preventivas; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="estado_solicitud">ESTADO DE LA SOLICITUD</label>
                    <!--<input type="text" class="form-control" id="estado_solicitud" name="estado_solicitud" value="<?=$estado_solicitud?>">-->
                    <select <?=$active?> required class="form-control" name="estado_solicitud">
                       <?php echo $combo_estado_solicitud; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_asignado_ot">FECHA ASIGNADO OT</label>
                    <input type="date" class="form-control" id="fecha_asignado_ot" name="fecha_asignado_ot" value="<?=$fecha_asignado_ot?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_reasignacion_ot">FECHA REASIGNACION OT</label>
                    <input type="date" class="form-control" id="fecha_reasignacion_ot" name="fecha_reasignacion_ot" value="<?=$fecha_reasignacion_ot?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="estado_ot">ESTADO OT</label>
                    <!--<input type="text" class="form-control" id="estado_ot" name="estado_ot" value="<?=$estado_ot?>">-->
                    <select <?=$active?> required class="form-control" name="estado_ot">
                       <?php echo $combo_estado_ot; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="ot">OT</label>
                    <input type="text" class="form-control" id="ot" name="ot" value="<?=$ot?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="analista_riesgo">ANALISTA DE RIESGO</label>
                    <!--<input type="text" class="form-control" id="analista_riesgo" name="analista_riesgo" value="<?=$analista_riesgo?>">-->
                    <select <?=$active?> required class="form-control" name="analista_riesgo">
                       <?php echo $combo_analista_riesgo; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="analista_riesgo_dos">ANALISTA DE RIESGO DOS</label>
                    <!--<input type="text" class="form-control" id="analista_riesgo_dos" name="analista_riesgo_dos" value="<?=$analista_riesgo_dos?>">-->
                    <select <?=$active?> required class="form-control" name="analista_riesgo_dos">
                       <?php echo $combo_analista_riesgo; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="analista_calidad">ANALISTA DE CALIDAD</label>
                    <!--<input type="text" class="form-control" id="analista_calidad" name="analista_calidad" value="<?=$analista_calidad?>">-->
                    <select <?=$active?> required class="form-control" name="analista_calidad">
                       <?php echo $combo_analista_calidad; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="subpoblacion">SUBPOBLACION</label>
                    <!--<input type="text" class="form-control" id="subpoblacion" name="subpoblacion" value="<?=$subpoblacion?>">-->
                    <select <?=$active?> required class="form-control" name="subpoblacion">
                       <?php echo $combo_factor_diferencial; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tipo_estudio_riesgo">TIPO ESTUDIO DE RIESGO</label>
                    <!--<input type="text" class="form-control" id="tipo_estudio_riesgo" name="tipo_estudio_riesgo" value="<?=$tipo_estudio_riesgo?>">-->
                    <select <?=$active?> required class="form-control" name="tipo_estudio_riesgo">
                       <?php echo $combo_tipo_estudio_riesgo; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="tramite_emergencia">TRAMITE DE EMERGENCIA</label>
                    <input type="text" class="form-control" id="tramite_emergencia" name="tramite_emergencia" value="<?=$tramite_emergencia?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_tramite_emergencia">FECHA TRAMITE DE EMERGENCIA</label>
                    <input type="date" class="form-control" id="fecha_tramite_emergencia" name="fecha_tramite_emergencia" value="<?=$fecha_tramite_emergencia?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="ingreso_calidad">INGRESO A CALIDAD</label>
                    <input type="text" class="form-control" id="ingreso_calidad" name="ingreso_calidad" value="<?=$ingreso_calidad?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_aprobacion_calidad">FECHA APROBACION ASESOR TECNICO CALIDAD</label>
                    <input type="date" class="form-control" id="fecha_aprobacion_calidad" name="fecha_aprobacion_calidad" value="<?=$fecha_aprobacion_calidad?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_presentacion_premesa">FECHA PRESENTACION PREMESA</label>
                    <input type="date" class="form-control" id="fecha_presentacion_premesa" name="fecha_presentacion_premesa" value="<?=$fecha_presentacion_premesa?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="recomendacion_riesgo_premesa">RECOMENDACION DEL RIESGO PREMESA</label>
                    <input type="text" class="form-control" id="recomendacion_riesgo_premesa" name="recomendacion_riesgo_premesa" value="<?=$recomendacion_riesgo_premesa?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="recomendacion_medidas_premesa">RECOMENDACION DE MEDIDAS PREMESA</label>
                    <!--<input type="text" class="form-control" id="recomendacion_medidas_premesa" name="recomendacion_medidas_premesa" value="<?=$recomendacion_medidas_premesa?>">-->
                    <select <?=$active?> required class="form-control" name="recomendacion_medidas_premesa">
                       <?php echo $combo_recomendacion_premesa; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="observaciones_premesa">OBSERVACIONES PREMESA</label>
                    <input type="text" class="form-control" id="observaciones_premesa" name="observaciones_premesa" value="<?=$observaciones_premesa?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tiempo_gestion_graerr">TIEMPO GESTION GRAERR</label>
                    <input type="text" class="form-control" id="tiempo_gestion_graerr" name="tiempo_gestion_graerr" value="<?=$tiempo_gestion_graerr?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="remision_mesa_tecnica">REMISION MESA TECNICA</label>
                    <input type="text" class="form-control" id="remision_mesa_tecnica" name="remision_mesa_tecnica" value="<?=$remision_mesa_tecnica?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="mes_remision">MES DE REMISION</label>
                    <input type="number" class="form-control" id="mes_remision" name="mes_remision" min="1" max="12" value="<?=$mes_remision?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="ano_remision">AÑO DE REMISION</label>
                    <input type="number" class="form-control" id="ano_remision" name="ano_remision" min="1900" max="2099" value="<?=$ano_remision?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="observaciones">OBSERVACIONES</label>
                    <textarea class="form-control" id="observaciones" name="observaciones"> "<?=$observaciones?>" </textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="seguimiento">SEGUIMIENTO</label>
                    <!--<input type="text" class="form-control" id="seguimiento" name="seguimiento" value="<?=$seguimiento?>">-->
                    <select <?=$active?> required class="form-control" name="seguimiento">
                       <?php echo $combo_seguimiento; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="factor_diferencial">FACTOR DIFERENCIAL</label>
                    <!--<input type="text" class="form-control" id="factor_diferencial" name="factor_diferencial" value="<?=$factor_diferencial?>">-->
                    <select <?=$active?> required class="form-control" name="factor_diferencial">
                       <?php echo $combo_factor_diferencial; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="reporte_936">REPORTE 936</label>
                    <input type="text" class="form-control" id="reporte_936" name="reporte_936" value="<?=$reporte_936?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="verificacion">VERIFICACION</label>
                    <input type="text" class="form-control" id="verificacion" name="verificacion" value="<?=$verificacion?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="otros">OTROS</label>
                    <input type="text" class="form-control" id="otros" name="otros" value="<?=$otros?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="dev_traslados_poblacional">DEV/TRASLADOS POBLACIONAL</label>
                    <input type="text" class="form-control" id="dev_traslados_poblacional" name="dev_traslados_poblacional" value="<?=$dev_traslados_poblacional?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            
            <input style="visibility:hidden" name="registro" id="registro" value="<?=$s_registro?>"/>
             <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
             <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
        </form>
    </div>
            </div>
                 
                 
                 
                 
                 
                 
                 <div class="row">
                    <div class="col-md-9 col-lg-9">
                        <label for="registro">REGISTRO</label>
                        <input type="text" class="form-control" id="registro" name="registro"  value="<?=$registro?>"required>
                    </div>
                <div class="col-md-9 col-lg-9">
                    <label for="vigencia">VIGENCIA</label>
                    <!--<input type="text" class="form-control" id="vigencia" name="vigencia" value="<?=$vigencia?>"required>-->
                     <select <?=$active?> required class="form-control" name="vigencia">
                       <?php echo $combo_vigencia; ?>
                     </select> 
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_recepcion_unp">FECHA DE RECEPCION EN LA UNP</label>
                    <input type="date" class="form-control" id="fecha_recepcion_unp" name="fecha_recepcion_unp"  value="<?=$fecha_recepcion_unp?>" required>
                </div>
            </div>
                   
                   
                   
                   
                   
                  <div class="row">
                    <div class=" col-md-9 col-lg-9 "> 
                        <table class="table table-condensed">
                         <tbody>
                          <tr>
                              <td class='col-md-3' align="right"> Nombre del Grupo Interno: </td>
                              <td> <textarea class="form-control" id="grupoInterno" name="grupoInterno" required style="text-transform:uppercase;"><?=$s_grupoInterno?></textarea> </td>
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
         
             <input style="visibility:hidden" name="idGrupoInterno" id="idGrupoInterno" value="<?=$s_idGrupoInterno?>"/>
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
  
   