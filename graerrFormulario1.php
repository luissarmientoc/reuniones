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
      
             $s_registro                      = $row['registro'];
             $registro                      = $row['registro'];
             $vigencia                      = $row['vigencia'];
             $fecha_recepcion_unp           = $row['fecha_recepcion_unp'];
             $fecha_recepcion_graerr        = $row['fecha_recepcion_graerr'];
             $fecha_carta_solicitante       = $row['fecha_carta_solicitante'];
             $no_mem_ext                    = $row['no_mem_ext'];
             $otras_entradas_sigob          = $row['otras_entradas_sigob'];
             $no_folios                     = $row['no_folios'];
             $entidad_persona_solicitante  =$row['entidad_persona_solicitante'];
             $destinatario                  = $row['destinatario'];
             $tipo_documento                = $row['tipo_documento'];
             $no_documento                  = $row['no_documento'];
             $nombres_peticionario          = $row['nombres_apellidos_peticionario'];
             $apellidos_peticionario        = $row['nombres_apellidos_peticionario'];
             $seudonimo                     = $row['seudonimo'];
             $tipo_ruta                     = $row['tipo_ruta'];
             $descripcion_colectivo         = $row['descripcion_colectivo'];
             $nombre_colectivo              = $row['nombre_colectivo'];
             $no_personas_evaluar           = $row['no_personas_evaluar'];
             $genero                        = $row['genero'];
             $grupo_etnico                  = $row['grupo_etnico'];
             $correo_electronico            = $row['correo_electronico'];
             $no_de_contacto                = $row['no_de_contacto'];
             $otros_numeros_contacto        = $row['otros_numeros_contacto'];
             $direccion                     = $row['direccion'];
             $departamento                  = $row['departamento'];
             $municipio                     = $row['municipio'];
             $corregimiento_vereda          = $row['corregimiento_vereda'];
             $autoriza_envio_info           = $row['autoriza_envio_info'];
             $fecha_asignacion_analisis     = $row['fecha_asignacion_analisis'];
             $analista_solicitudes          = $row['analista_solicitudes'];
             $estado_solicitud              = $row['estado_solicitud'];
             $fecha_asignado_ot             = $row['fecha_asignado_ot'];
             $fecha_reasignacion_ot         = $row['fecha_reasignacion_ot'];
             $medidas_preventivas           = $row['medidas_preventivas'];
             $estado_ot                     = $row['estado_ot'];
             $ot                            = $row['ot'];
             $analista_riesgo               = $row['analista_riesgo'];
             $analista_riesgo_dos           = $row['analista_riesgo_dos'];
             $analista_calidad              = $row['analista_calidad'];
             $subpoblacion                  = $row['subpoblacion'];
             $tipo_estudio_riesgo           = $row['tipo_estudio_riesgo'];
             $es_tramite_emergencia         = $row['es_tramite_emergencia'];
             $tramite_emergencia            = $row['tramite_emergencia'];
             $fecha_tramite_emergencia      = $row['fecha_tramite_emergencia'];
             $ingreso_calidad               = $row['ingreso_calidad'];
             $fecha_aprobacion_calidad      = $row['fecha_aprobacion_calidad'];
             $fecha_presentacion_premesa    = $row['fecha_presentacion_premesa'];
             $recomendacion_riesgo_premesa  = $row['recomendacion_riesgo_premesa'];
             $recomendacion_medidas_premesa = $row['recomendacion_medidas_premesa'];
             $observaciones_premesa         = $row['observaciones_premesa'];
             $remision_mesa_tecnica         = $row['remision_mesa_tecnica'];
             $observaciones                 = $row['observaciones'];
             $otros                         = $row['otros'];
             
    }  
    else
    {
      $titulo = "NUEVO REGISTRO GRAERR";
      $s_existe = 0;
      $boton="Grabar";
      
      // GENERA EL NUMERO DEL NUEVO REGISTRO
        $sql = "SELECT MAX(registro) AS maximo FROM graerr_formulario";
       // echo '<br>';
        //echo $sql;
        //echo '<br>';
        $stmt = $pdo->query($sql);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $s_maximo = $row['maximo'];
        
        $s_registro     = $s_maximo+1;
        //echo '<br>';
        //echo "el regi..·" . $s_registro;
        //echo '<br>';
    }  
 
   
   if(isset($_POST['grabar']))
   { 
       
       $s_existe         = $_POST['existe'];
       $s_yaGrabo        = $_POST['yaGrabo'];
    
       date_default_timezone_set('America/Bogota');
       //$s_fecha  = date("Y-m-d",time());
       //$s_fecha  = date("Y/m/d H:i:s");
       $date_added=date("Y-m-d H:i:s");
             $s_registro                     = $_POST['registro'];
             $registro                      = $_POST['registro'];
             $vigencia                      = $_POST['vigencia'];
             $fecha_recepcion_unp           = $_POST['fecha_recepcion_unp'];
             $fecha_recepcion_graerr        = $_POST['fecha_recepcion_graerr'];
             $fecha_carta_solicitante       = $_POST['fecha_carta_solicitante'];
             $no_mem_ext                    = $_POST['no_mem_ext'];
             $otras_entradas_sigob          = $_POST['otras_entradas_sigob'];
             $no_folios                     = $_POST['no_folios'];
             $entidad_persona_solicitante   = $_POST['entidad_persona_solicitante'];
             $destinatario                  = $_POST['destinatario'];
             $tipo_documento                = $_POST['tipo_documento'];
             $no_documento                  = $_POST['no_documento'];
             $nombres_peticionario          = $_POST['nombres_apellidos_peticionario'];
             $apellidos_peticionario        = $_POST['nombres_apellidos_peticionario'];
             $seudonimo                     = $_POST['seudonimo'];
             $tipo_ruta                     = $_POST['tipo_ruta'];
             $descripcion_colectivo         = $_POST['descripcion_colectivo'];
             $nombre_colectivo              = $_POST['nombre_colectivo'];
             $no_personas_evaluar           = $_POST['no_personas_evaluar'];
             $genero                        = $_POST['genero'];
             $grupo_etnico                  = $_POST['grupo_etnico'];
             $correo_electronico            = $_POST['correo_electronico'];
             $no_de_contacto                = $_POST['no_de_contacto'];
             $otros_numeros_contacto        = $_POST['otros_numeros_contacto'];
             $direccion                     = $_POST['direccion'];
             $departamento                  = $_POST['departamento'];
             $municipio                     = $_POST['municipio'];
             $corregimiento_vereda          = $_POST['corregimiento_vereda'];
             $autoriza_envio_info           = $_POST['autoriza_envio_info'];
             $fecha_asignacion_analisis     = $_POST['fecha_asignacion_analisis'];
             $analista_solicitudes          = $_POST['analista_solicitudes'];
             $estado_solicitud              = $_POST['estado_solicitud'];
             $fecha_asignado_ot             = $_POST['fecha_asignado_ot'];
             $fecha_reasignacion_ot         = $_POST['fecha_reasignacion_ot'];
             $medidas_preventivas           = $_POST['medidas_preventivas'];
             $estado_ot                     = $_POST['estado_ot'];
             $ot                            = $_POST['ot'];
             $analista_riesgo               = $_POST['analista_riesgo'];
             $analista_riesgo_dos           = $_POST['analista_riesgo_dos'];
             $analista_calidad              = $_POST['analista_calidad'];
             $subpoblacion                  = $_POST['subpoblacion'];
             $tipo_estudio_riesgo           = $_POST['tipo_estudio_riesgo'];
             $es_tramite_emergencia         = $_POST['es_tramite_emergencia'];
             $tramite_emergencia            = $_POST['tramite_emergencia'];
             $fecha_tramite_emergencia      = $_POST['fecha_tramite_emergencia'];
             $ingreso_calidad               = $_POST['ingreso_calidad'];
             $fecha_aprobacion_calidad      = $_POST['fecha_aprobacion_calidad'];
             $fecha_presentacion_premesa    = $_POST['fecha_presentacion_premesa'];
             $recomendacion_riesgo_premesa  = $_POST['recomendacion_riesgo_premesa'];
             $recomendacion_medidas_premesa = $_POST['recomendacion_medidas_premesa'];
             $observaciones_premesa         = $_POST['observaciones_premesa'];
             $remision_mesa_tecnica         = $_POST['remision_mesa_tecnica'];
             $observaciones                 = $_POST['observaciones'];
             $otros                         = $_POST['otros'];
       
    echo "entra a grabar";
          echo '<br>';
          echo "1.." . $_POST['registro'];
          echo '<br>';
     
         
    echo "1.." . $registro;
    echo '<br>';
    echo "2.la vigencia." . $vigencia;
    echo '<br>';
    echo "3.." . $fecha_recepcion_unp;
    echo '<br>';
    echo "4.." . $fecha_recepcion_graerr;
    echo '<br>';
    echo "5.." . $fecha_carta_solicitante;
    echo '<br>';
    echo "6.." . $no_mem_ext;
    echo '<br>';
    echo "7.." . $otras_entradas_sigob;
    echo '<br>';
    echo "8.." . $no_folios;
    echo '9br>';
    echo "10.." . $entidad_persona_solicitante;
    echo '<br>';
    echo "11.." . $destinatario;
    echo '<br>';
    echo "12.." . $tipo_documento;
    echo '<br>';
    echo "13.." . $no_documento;
    echo '<br>';
    echo "14.." . $nombres_peticionario;
    echo '<br>';
    echo "15.." . $apellidos_peticionario;
    echo '<br>';
    echo "16.." . $seudonimo;
    echo '<br>';
    echo "17.." . $tipo_ruta;
    echo '<br>';
    echo "18.." . $descripcion_colectivo;
    echo '<br>';
    echo "19.." . $nombre_colectivo;
    echo '<br>';
    echo "20.." . $no_personas_evaluar;
    echo '<br>';
    echo "21.." . $genero;
    echo '<br>';
    echo "22.." . $grupo_etnico;
    echo '<br>';
    echo "58.." . $factor_diferencial;
    echo '<br>';
    echo "23.." . $correo_electronico;
    echo '<br>';
    echo "24.." . $no_de_contacto; 
    echo '<br>';
    echo "25.." . $otros_numeros_contacto;
    echo '<br>';
    echo "26.." . $direccion;
    echo '<br>';
    echo "27.." . $departamento;
    echo '<br>';
    echo "28.." . $municipio;
    echo '<br>';
    echo "29.." . $corregimiento_vereda;
    echo '<br>';
    echo "30.." . $autoriza_envio_info;
    echo '<br>';
    echo "31.." . $fecha_asignacion_analisis;
    echo '<br>';
    echo "32.." . $analista_solicitudes;
    echo '<br>';
    echo "34.." . $estado_solicitud;
    echo '<br>';
    echo "35.." . $fecha_asignado_ot;
    echo '<br>';
    echo "36.." . $fecha_reasignacion_ot;
    echo '<br>';
    echo "33.." . $medidas_preventivas;
    echo '<br>';
    echo "37.." . $estado_ot;
    echo '<br>';
    echo "38.." . $ot;
    echo '<br>';
    echo "39.." . $analista_riesgo;
    echo '<br>';
    echo "40.." . $analista_riesgo_dos;
    echo '<br>';
    echo "41.." . $analista_calidad;
    echo '<br>';
    echo "42.." . $subpoblacion;
    echo '<br>';
    echo "43.." . $tipo_estudio_riesgo;
    echo '<br>';
    echo "57.." . $seguimiento;
    echo '<br>';
    echo "44a.." . $es_tramite_emergencia;
    echo '<br>';
    echo '<br>';
    echo "44.." . $tramite_emergencia;
    echo '<br>';
    echo "45.." . $fecha_tramite_emergencia;
    echo '<br>';
    echo "46.." . $ingreso_calidad;
    echo '<br>';
    echo "47.." . $fecha_aprobacion_calidad;
    echo '<br>';
    echo "48.." . $fecha_presentacion_premesa;
    echo '<br>';
    echo "49.." . $recomendacion_riesgo_premesa;
    echo '<br>';
    echo "50.." . $recomendacion_medidas_premesa;
    echo '<br>';
    echo "51.." . $observaciones_premesa;
    echo '<br>';
    echo "53.." . $remision_mesa_tecnica;
    echo '<br>';
    echo "56.." . $observaciones;
    echo '<br>';
    echo "61.." . $otros;
    echo '<br>';
      
       ///MODIFICA
      if ($s_existe == "1")  
      {
         // Preparar la consulta SQL para actualizar el registro
         $sql = "UPDATE formulario SET
             registro = :registro,
             vigencia = :vigencia,
             fecha_recepcion_unp = :fecha_recepcion_unp,
             fecha_recepcion_graerr = :fecha_recepcion_graerr,
             fecha_carta_solicitante = :fecha_carta_solicitante,
             no_mem_ext = :no_mem_ext,
             otras_entradas_sigob = :otras_entradas_sigob,
             no_folios = :no_folios,
             entidad_persona_solicitante = :entidad_persona_solicitante,
             destinatario = :destinatario,
             tipo_documento = :tipo_documento,
             no_documento = :no_documento,
             nombres_apellidos_peticionario = :nombres_apellidos_peticionario,
             seudonimo = :seudonimo,
             tipo_ruta = :tipo_ruta,
             descripcion_colectivo = :descripcion_colectivo,
             nombre_colectivo = :nombre_colectivo,
             no_personas_evaluar = :no_personas_evaluar,
             genero = :genero,
             grupo_etnico = :grupo_etnico,
             correo_electronico = :correo_electronico,
             no_de_contacto = :no_de_contacto,
             otros_numeros_contacto = :otros_numeros_contacto,
             direccion = :direccion,
             departamento = :departamento,
             municipio = :municipio,
             corregimiento_vereda = :corregimiento_vereda,
             autoriza_envio_info = :autoriza_envio_info,
             fecha_asignacion_analisis = :fecha_asignacion_analisis,
             analista_solicitudes = :analista_solicitudes,
             medidas_preventivas = :medidas_preventivas,
             estado_solicitud = :estado_solicitud,
             fecha_asignado_ot = :fecha_asignado_ot,
             fecha_reasignacion_ot = :fecha_reasignacion_ot,
             estado_ot = :estado_ot,
             ot = :ot,
             analista_riesgo = :analista_riesgo,
             analista_riesgo_dos = :analista_riesgo_dos,
             analista_calidad = :analista_calidad,
             subpoblacion = :subpoblacion,
             tipo_estudio_riesgo = :tipo_estudio_riesgo,
             tramite_emergencia = :tramite_emergencia,
             fecha_tramite_emergencia = :fecha_tramite_emergencia,
             ingreso_calidad = :ingreso_calidad,
             fecha_aprobacion_calidad = :fecha_aprobacion_calidad,
             fecha_presentacion_premesa = :fecha_presentacion_premesa,
             recomendacion_riesgo_premesa = :recomendacion_riesgo_premesa,
             recomendacion_medidas_premesa = :recomendacion_medidas_premesa,
             observaciones_premesa = :observaciones_premesa,
             tiempo_gestion_graerr = :tiempo_gestion_graerr,
             remision_mesa_tecnica = :remision_mesa_tecnica,
             mes_remision = :mes_remision,
             ano_remision = :ano_remision,
             observaciones = :observaciones,
             seguimiento = :seguimiento,
             factor_diferencial = :factor_diferencial,
             reporte_936 = :reporte_936,
             verificacion = :verificacion,
             otros = :otros,
             dev_traslados_poblacional = :dev_traslados_poblacional
         WHERE id = :id";

         // Preparar la declaración
         $stmt = $conn->prepare($sql);

         // Bindear los parámetros
         $stmt->bindParam(':registro', $_POST['registro']);
         $stmt->bindParam(':vigencia', $_POST['vigencia']);
         $stmt->bindParam(':fecha_recepcion_unp', $_POST['fecha_recepcion_unp']);
         $stmt->bindParam(':fecha_recepcion_graerr', $_POST['fecha_recepcion_graerr']);
         $stmt->bindParam(':fecha_carta_solicitante', $_POST['fecha_carta_solicitante']);
         $stmt->bindParam(':no_mem_ext', $_POST['no_mem_ext']);
         $stmt->bindParam(':otras_entradas_sigob', $_POST['otras_entradas_sigob']);
         $stmt->bindParam(':no_folios', $_POST['no_folios']);
         $stmt->bindParam(':entidad_persona_solicitante', $_POST['entidad_persona_solicitante']);
         $stmt->bindParam(':destinatario', $_POST['destinatario']);
         $stmt->bindParam(':tipo_documento', $_POST['tipo_documento']);
         $stmt->bindParam(':no_documento', $_POST['no_documento']);
         $stmt->bindParam(':nombres_apellidos_peticionario', $_POST['nombres_apellidos_peticionario']);
         $stmt->bindParam(':seudonimo', $_POST['seudonimo']);
         $stmt->bindParam(':tipo_ruta', $_POST['tipo_ruta']);
         $stmt->bindParam(':descripcion_colectivo', $_POST['descripcion_colectivo']);
         $stmt->bindParam(':nombre_colectivo', $_POST['nombre_colectivo']);
         $stmt->bindParam(':no_personas_evaluar', $_POST['no_personas_evaluar']);
         $stmt->bindParam(':genero', $_POST['genero']);
         $stmt->bindParam(':grupo_etnico', $_POST['grupo_etnico']);
         $stmt->bindParam(':correo_electronico', $_POST['correo_electronico']);
         $stmt->bindParam(':no_de_contacto', $_POST['no_de_contacto']);
         $stmt->bindParam(':otros_numeros_contacto', $_POST['otros_numeros_contacto']);
         $stmt->bindParam(':direccion', $_POST['direccion']);
         $stmt->bindParam(':departamento', $_POST['departamento']);
         $stmt->bindParam(':municipio', $_POST['municipio']);
         $stmt->bindParam(':corregimiento_vereda', $_POST['corregimiento_vereda']);
         $stmt->bindParam(':autoriza_envio_info', $_POST['autoriza_envio_info']);
         $stmt->bindParam(':fecha_asignacion_analisis', $_POST['fecha_asignacion_analisis']);
         $stmt->bindParam(':analista_solicitudes', $_POST['analista_solicitudes']);
         $stmt->bindParam(':medidas_preventivas', $_POST['medidas_preventivas']);
         $stmt->bindParam(':estado_solicitud', $_POST['estado_solicitud']);
         $stmt->bindParam(':fecha_asignado_ot', $_POST['fecha_asignado_ot']);
         $stmt->bindParam(':fecha_reasignacion_ot', $_POST['fecha_reasignacion_ot']);
         $stmt->bindParam(':estado_ot', $_POST['estado_ot']);
         $stmt->bindParam(':ot', $_POST['ot']);
         $stmt->bindParam(':analista_riesgo', $_POST['analista_riesgo']);
         $stmt->bindParam(':analista_riesgo_dos', $_POST['analista_riesgo_dos']);
         $stmt->bindParam(':analista_calidad', $_POST['analista_calidad']);
         $stmt->bindParam(':subpoblacion', $_POST['subpoblacion']);
         $stmt->bindParam(':tipo_estudio_riesgo', $_POST['tipo_estudio_riesgo']);
         $stmt->bindParam(':tramite_emergencia', $_POST['tramite_emergencia']);
         $stmt->bindParam(':fecha_tramite_emergencia', $_POST['fecha_tramite_emergencia']);
         $stmt->bindParam(':ingreso_calidad', $_POST['ingreso_calidad']);
         $stmt->bindParam(':fecha_aprobacion_calidad', $_POST['fecha_aprobacion_calidad']);
         $stmt->bindParam(':fecha_presentacion_premesa', $_POST['fecha_presentacion_premesa']);
         $stmt->bindParam(':recomendacion_riesgo_premesa', $_POST['recomendacion_riesgo_premesa']);
         $stmt->bindParam(':recomendacion_medidas_premesa', $_POST['recomendacion_medidas_premesa']);
         $stmt->bindParam(':observaciones_premesa', $_POST['observaciones_premesa']);
         $stmt->bindParam(':tiempo_gestion_graerr', $_POST['tiempo_gestion_graerr']);
         $stmt->bindParam(':remision_mesa_tecnica', $_POST['remision_mesa_tecnica']);
       //  $stmt->bindParam(':mes_remision', $_POST['mes_remision']);
       // $stmt->bindParam(':ano_remision', $_POST['ano_remision']);
         $stmt->bindParam(':observaciones', $_POST['observaciones']);
         $stmt->bindParam(':seguimiento', $_POST['seguimiento']);
         $stmt->bindParam(':factor_diferencial', $_POST['factor_diferencial']);
       //  $stmt->bindParam(':reporte_936', $_POST['reporte_936']);
       // $stmt->bindParam(':verificacion', $_POST['verificacion']);
         $stmt->bindParam(':otros', $_POST['otros']);
         $stmt->bindParam(':dev_traslados_poblacional', $_POST['dev_traslados_poblacional']);
         $stmt->bindParam(':id', $_POST['id']); // Aquí se incluye el ID del registro a actualizar

         // Ejecutar la consulta
         if ($stmt->execute()) {
             echo "Datos actualizados correctamente.";
         } else {
             echo "Error al actualizar los datos.";
         }
    }//modificar
      
    ///ADICIONA
    if ($s_existe == "0")
    {
try {
    // Conectar a la base de datos
    //$conn = new PDO("pgsql:host=localhost;dbname=mi_base_de_datos", "mi_usuario", "mi_contraseña");
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar la consulta SQL
    
        $stmt = $pdo->prepare('INSERT INTO graerr_formulario_a (
                      id, registro, vigencia, fecha_recepcion_unp, fecha_recepcion_graerr, fecha_carta_solicitante,
                      no_mem_ext, otras_entradas_sigob, no_folios, entidad_persona_solicitante, destinatario) VALUES ( VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$id, $registro, $vigencia, $fecha_recepcion_unp, $fecha_recepcion_graerr, $fecha_carta_solicitante,
                      $no_mem_ext, $otras_entradas_sigob, $no_folios, $entidad_persona_solicitante, $destinatario]);
    echo "Datos insertados correctamente.";
} catch (PDOException $e) {
    echo "Error al insertar los datos: " . $e->getMessage();
}
    }//existe=0
    
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
        $combo_vigencia .=" <option value='".$line['ano']."' selected>".$line['ano']." </option>"; 
      }
     // $combo_vigencia .=" <option value='".$line['ano']."'>".$line['ano']."</ano>"; 
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
                               <input type="text" class="form-control" id="registro" name="registro"  value="<?=$s_registro?>" required readonly>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                               <label for="vigencia">VIGENCIA</label>
                              
                                <select <?=$active?> required class="form-control" id="vigencia" name="vigencia">
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
                               <input type="text" class="form-control" id="no_mem_ext" name="no_mem_ext"  value="<?=$no_mem_ext?>" required  style="text-transform:uppercase;">
                           </div>
                           
                           <div class="col-sm-3" align="left">
                                <label for="otras_entradas_sigob">OTRAS ENTRADAS SIGOB</label>
                                <input type="text" class="form-control" id="otras_entradas_sigob" name="otras_entradas_sigob"  value="<?=$otras_entradas_sigob?>"  style="text-transform:uppercase;">
                            </div>
                            
                            <div class="col-sm-3" align="left">
                                <label for="no_folios">No FOLIOS</label>
                                <input type="number" class="form-control" id="no_folios" name="no_folios"  value="<?=$no_folios?>" required>
                            </div>
                       </div> <!--row-->    
                       
                       <div class="row" style="margin-top:5px;">    
                            <div class="col-sm-6" align="left">
                                <label for="entidad_persona_solicitante">ENTIDAD/PERSONA SOLICITANTE</label>
                                <input  style="text-transform:uppercase;" type="text" class="form-control" id="entidad_persona_solicitante" name="entidad_persona_solicitante"  value="<?=$entidad_persona_solicitante?>" required>
                            </div>
                            
                            <div class="col-sm-6" align="left">
                                <label for="destinatario">DESTINATARIO</label>
                                <input  style="text-transform:uppercase;" type="text" class="form-control" id="destinatario" name="destinatario"  value="<?=$destinatario?>" required>
                            </div>
                       </div> <!--row-->
                    </div> <!--container-->
                    
                    <div class="container"  style="margin-bottom:10px;">   
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
                               <input type="number" class="form-control" id="no_documento" name="no_documento"  value="<?=$no_documento?>" required>
                           </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">   
                           <div class="col-sm-4" align="left">
                               <label style="font-size:12px;" for="nombres_apellidos_peticionario">NOMBRES PETICIONARIO O BENEFICIARIO</label>
                               <input  style="text-transform:uppercase;" type="text" class="form-control" id="nombres_apellidos_peticionario" name="nombres_apellidos_peticionario"  value="<?=$nombres_apellidos_peticionario?>" required>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label style="font-size:12px;" for="nombres_apellidos_peticionario">APELLIDOS PETICIONARIO O BENEFICIARIO</label>
                               <input  style="text-transform:uppercase;" type="text" class="form-control" id="nombres_apellidos_peticionario" name="nombres_apellidos_peticionario"  value="<?=$nombres_apellidos_peticionario?>" required>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="seudonimo">SEUDONIMO</label>
                               <input  style="text-transform:uppercase;" type="text" class="form-control" id="seudonimo" name="seudonimo"  value="<?=$seudonimo?>">
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
                              <input  style="text-transform:uppercase;" type="text" class="form-control" id="descripcion_colectivo" name="descripcion_colectivo"  value="<?=$descripcion_colectivo?>">
                          </div>
                          
                          <div class="col-sm-4" align="left">
                              <label for="nombre_colectivo">NOMBRE COLECTIVO</label>
                              <input  style="text-transform:uppercase;" type="text" class="form-control" id="nombre_colectivo" name="nombre_colectivo"  value="<?=$nombre_colectivo?>">
                          </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">   
                           <div class="col-sm-3" align="left">
                               <label for="no_personas_evaluar">No PERSONAS A EVALUAR</label>
                               <input type="number" class="form-control" id="no_personas_evaluar" name="no_personas_evaluar"  value="<?=$no_personas_evaluar?>" required>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                               <label for="genero">GENERO</label>
                               <!--<input type="text" class="form-control" id="genero" name="genero"  value="<?=$genero?>">-->
                               <select <?=$active?> required class="form-control" name="genero">
                                  <?php echo $combo_genero; ?>
                               </select>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                               <label for="grupo_etnico">GRUPO ETNICO</label>
                               <!--<input type="text" class="form-control" id="grupo_etnico" name="grupo_etnico"  value="<?=$grupo_etnico?>">-->
                               <select <?=$active?> required class="form-control" name="grupo_etnico">
                                  <?php echo $combo_grupo_etnico; ?>
                               </select>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                               <label for="factor_diferencial">FACTOR DIFERENCIAL</label>
                               <!--<input type="text" class="form-control" id="factor_diferencial" name="factor_diferencial" value="<?=$factor_diferencial?>">-->
                               <select <?=$active?> required class="form-control" name="factor_diferencial">
                                  <?php echo $combo_factor_diferencial; ?>
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
                              <input type="number" class="form-control" id="no_de_contacto" name="no_de_contacto"  value="<?=$no_de_contacto?>" required>
                          </div>
                          <div class="col-sm-4" align="left">
                              <label for="otros_numeros_contacto">OTROS NUMEROS DE CONTACTO</label>
                              <input type="number" class="form-control" id="otros_numeros_contacto" name="otros_numeros_contacto"  value="<?=$otros_numeros_contacto?>">
                          </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">  
                           <div class="col-sm-4" align="left">  
                              <label for="direccion">DIRECCION</label>
                              <input style="text-transform:uppercase;"  type="text" class="form-control" id="direccion" name="direccion"  value="<?=$direccion?>" required>
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
                          <div class="col-sm-8" align="left">
                              <label for="corregimiento_vereda">CORREGIMIENTO O VEREDA</label>
                              <input  style="text-transform:uppercase;" type="text" class="form-control" id="corregimiento_vereda" name="corregimiento_vereda" value="<?=$corregimiento_vereda?>" required>
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
                       
                       <div class="row" style="margin-top:5px;"> 
                          <div class="col-sm-4" align="left">
                              <label for="autoriza_envio_info">AUTORIZA ENVIO DE INFO POR CORREO</label>
                              <select class="form-control" id="autoriza_envio_info" name="autoriza_envio_info" value="<?=$autoriza_envio_info?>">
                                  <option value="si">Sí</option>
                                  <option value="no">No</option>
                              </select>
                          </div>
                          
                          <div class="col-sm-4" align="left">
                              <label for="fecha_asignacion_analisis">FECHA ASIGNACION ANALISIS PRELIMINAR</label>
                              <input type="date" class="form-control" id="fecha_asignacion_analisis" name="fecha_asignacion_analisis" value="<?=$fecha_asignacion_analisis?>">
                          </div>
                          
                          <div class="col-sm-4" align="left">
                              <label for="analista_solicitudes">ANALISTA DE SOLICITUDES</label>
                              <select <?=$active?> required class="form-control" name="analista_solicitudes">
                                 <?php echo $combo_analista_solicitudes; ?>
                              </select>
                          </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="estado_solicitud">ESTADO DE LA SOLICITUD</label>
                               <!--<input type="text" class="form-control" id="estado_solicitud" name="estado_solicitud" value="<?=$estado_solicitud?>">-->
                               <select <?=$active?> required class="form-control" name="estado_solicitud">
                                  <?php echo $combo_estado_solicitud; ?>
                               </select>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="fecha_asignado_ot">FECHA ASIGNADO OT</label>
                               <input type="date" class="form-control" id="fecha_asignado_ot" name="fecha_asignado_ot" value="<?=$fecha_asignado_ot?>">
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="fecha_reasignacion_ot">FECHA REASIGNACION OT</label>
                               <input type="date" class="form-control" id="fecha_reasignacion_ot" name="fecha_reasignacion_ot" value="<?=$fecha_reasignacion_ot?>">
                           </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="medidas_preventivas">MEDIDAS PREVENTIVAS</label>
                               <!--<input type="text" class="form-control" id="medidas_preventivas" name="medidas_preventivas" value="<?=$medidas_preventivas?>">-->
                               <select <?=$active?> required class="form-control" name="medidas_preventivas">
                                  <?php echo $combo_medidas_preventivas; ?>
                               </select>
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="estado_ot">ESTADO OT</label>
                               <!--<input type="text" class="form-control" id="estado_ot" name="estado_ot" value="<?=$estado_ot?>">-->
                               <select <?=$active?> required class="form-control" name="estado_ot">
                                  <?php echo $combo_estado_ot; ?>
                               </select>
                           </div>
                          <div class="col-sm-4" align="left">
                               <label for="ot">OT</label>
                               <input type="text" class="form-control" id="ot" name="ot" value="<?=$ot?>">
                           </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="analista_riesgo">ANALISTA DE RIESGO</label>
                               <!--<input type="text" class="form-control" id="analista_riesgo" name="analista_riesgo" value="<?=$analista_riesgo?>">-->
                               <select <?=$active?> required class="form-control" name="analista_riesgo">
                                  <?php echo $combo_analista_riesgo; ?>
                               </select>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="analista_riesgo_dos">ANALISTA DE RIESGO DOS</label>
                               <!--<input type="text" class="form-control" id="analista_riesgo_dos" name="analista_riesgo_dos" value="<?=$analista_riesgo_dos?>">-->
                               <select <?=$active?> required class="form-control" name="analista_riesgo_dos">
                                  <?php echo $combo_analista_riesgo; ?>
                               </select>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="analista_calidad">ANALISTA DE CALIDAD</label>
                               <!--<input type="text" class="form-control" id="analista_calidad" name="analista_calidad" value="<?=$analista_calidad?>">-->
                               <select <?=$active?> required class="form-control" name="analista_calidad">
                                  <?php echo $combo_analista_calidad; ?>
                               </select>
                           </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;"> 
                          <div class="col-sm-4" align="left">
                              <label for="subpoblacion">SUBPOBLACION</label>
                              <!--<input type="text" class="form-control" id="subpoblacion" name="subpoblacion" value="<?=$subpoblacion?>">-->
                              <select <?=$active?> required class="form-control" name="subpoblacion">
                                 <?php echo $combo_factor_diferencial; ?>
                              </select>
                          </div>
                
                          <div class="col-sm-4" align="left">
                              <label for="tipo_estudio_riesgo">TIPO ESTUDIO DE RIESGO</label>
                              <!--<input type="text" class="form-control" id="tipo_estudio_riesgo" name="tipo_estudio_riesgo" value="<?=$tipo_estudio_riesgo?>">-->
                              <select <?=$active?> required class="form-control" name="tipo_estudio_riesgo">
                                 <?php echo $combo_tipo_estudio_riesgo; ?>
                              </select>
                          </div>
                          
                           <div class="col-sm-4" align="left">
                               <label for="seguimiento">SEGUIMIENTO</label>
                               <!--<input type="text" class="form-control" id="seguimiento" name="seguimiento" value="<?=$seguimiento?>">-->
                               <select <?=$active?> required class="form-control" name="seguimiento">
                                  <?php echo $combo_seguimiento; ?>
                               </select>
                           </div>
                       </div> <!--row-->
                       
                       <!--
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="reporte_936">REPORTE 936</label>
                               <input type="text" class="form-control" id="reporte_936" name="reporte_936" value="<?=$reporte_936?>">
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="verificacion">VERIFICACION</label>
                               <input type="text" class="form-control" id="verificacion" name="verificacion" value="<?=$verificacion?>">
                           </div>
                       </div> <!--row
                       -->
                        
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
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="tramite_emergencia">ES TRAMITE DE EMERGENCIA?</label>
                               <select class="form-control" id="es_tramite_emergencia" name="es_tramite_emergencia" value="<?=$autoriza_envio_info?>">
                                  <option value="si">Sí</option>
                                  <option value="no">No</option>
                               </select>
                           </div>
                        </div>   
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="tramite_emergencia">TRAMITE DE EMERGENCIA</label>
                               <input type="text" class="form-control" id="tramite_emergencia" name="tramite_emergencia" value="<?=$tramite_emergencia?>">
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="fecha_tramite_emergencia">FECHA TRAMITE DE EMERGENCIA</label>
                               <input type="date" class="form-control" id="fecha_tramite_emergencia" name="fecha_tramite_emergencia" value="<?=$fecha_tramite_emergencia?>">
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="ingreso_calidad">INGRESO A CALIDAD</label>
                               <input type="date" class="form-control" id="ingreso_calidad" name="ingreso_calidad" value="<?=$ingreso_calidad?>">
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                              <label for="fecha_aprobacion_calidad">FECHA APROBACION ASESOR TECNICO CALIDAD</label>
                              <input type="date" class="form-control" id="fecha_aprobacion_calidad" name="fecha_aprobacion_calidad" value="<?=$fecha_aprobacion_calidad?>">
                           </div>
                           <div class="col-sm-4" align="left">
                              <label for="fecha_presentacion_premesa">FECHA PRESENTACION PREMESA</label>
                              <input type="date" class="form-control" id="fecha_presentacion_premesa" name="fecha_presentacion_premesa" value="<?=$fecha_presentacion_premesa?>">
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="recomendacion_medidas_premesa">RECOMENDACION DE MEDIDAS PREMESA</label>
                               <!--<input type="text" class="form-control" id="recomendacion_medidas_premesa" name="recomendacion_medidas_premesa" value="<?=$recomendacion_medidas_premesa?>">-->
                               <select <?=$active?> required class="form-control" name="recomendacion_medidas_premesa">
                                  <?php echo $combo_recomendacion_premesa; ?>
                               </select>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                              <label for="recomendacion_riesgo_premesa">RECOMENDACION DEL RIESGO PREMESA</label>
                              <textarea  style="text-transform:uppercase;" class="form-control" id="recomendacion_riesgo_premesa" name="recomendacion_riesgo_premesa" rows="5"> <?=$recomendacion_riesgo_premesa?> </textarea>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                               <label for="observaciones_premesa">OBSERVACIONES PREMESA</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="observaciones_premesa" name="observaciones_premesa" rows="5"> <?=$observaciones_premesa?> </textarea>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <!--
                           <div class="col-sm-3" align="left">
                               <label for="tiempo_gestion_graerr">TIEMPO GESTION GRAERR</label>
                               <input type="text" class="form-control" id="tiempo_gestion_graerr" name="tiempo_gestion_graerr" value="<?=$tiempo_gestion_graerr?>">
                           </div>
                           -->
                           <div class="col-sm-3" align="left">
                               <label for="remision_mesa_tecnica">REMISION MESA TECNICA</label>
                               <input type="date" class="form-control" id="remision_mesa_tecnica" name="remision_mesa_tecnica" value="<?=$remision_mesa_tecnica?>">
                           </div>
                           <!--
                           <div class="col-sm-3" align="left">
                               <label for="mes_remision">MES DE REMISION</label>
                               <input type="number" class="form-control" id="mes_remision" name="mes_remision" min="1" max="12" value="<?=$mes_remision?>">
                           </div>
                           <div class="col-sm-3" align="left">
                               <label for="ano_remision">AÑO DE REMISION</label>
                               <input type="number" class="form-control" id="ano_remision" name="ano_remision" min="1900" max="2099" value="<?=$ano_remision?>">
                           </div>
                           -->
                        </div> <!--row-->
                       
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                               <label for="observaciones">OBSERVACIONES</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="observaciones" name="observaciones" rows="5"> <?=$observaciones?> </textarea>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                               <label for="otros">OTROS</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="otros" name="otros" rows="5"> <?=$otros?> </textarea>
                           </div>
                           <!--
                           <div class="col-sm-6" align="left">
                               <label for="dev_traslados_poblacional">DEV/TRASLADOS POBLACIONAL</label>
                               <input type="text" class="form-control" id="dev_traslados_poblacional" name="dev_traslados_poblacional" value="">
                           </div>
                           -->
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-6" align="left">
                            </div>
                        </div>       
                    </div> <!--container-->
                  </div>
                </div> <!-- panel body -->	 
              
               <div class="modal-footer"> 
                <div class="col-sm-11" align="center">  					  			 
                  <button type="submit" name='grabar' class="btn btn-md btn-success btn-lg"><i class="glyphicon glyphicon-refresh"></i> <?=$boton?> </button>
                </div>	 
              </div>
         
             <input style="visibility:hidden" name="idGrupoInterno" id="idGrupoInterno" value="<?=$s_registro?>"/>
             <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
             <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
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
  
   