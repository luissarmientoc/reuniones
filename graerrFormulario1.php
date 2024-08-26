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
        
            
         <script>
              document.addEventListener('DOMContentLoaded', function() {
             // Función para actualizar los campos con la información seleccionada
            
    
             // Event listener para el cambio en el select con id 'es_tramite_emergencia'
             document.getElementById('es_tramite_emergencia').addEventListener('change', function() {
                 const miDiv = document.getElementById('emergencia');
                 const seleccion = this.value;

                 if (seleccion === 'no') {
                     miDiv.style.display = 'none';
                 } else {
                     miDiv.style.display = 'block';
                 }
             });

             // Event listener para el cambio en el select con id 'tipo_ruta'
             document.getElementById('tipo_ruta').addEventListener('change', function() {
                 const miDiv1 = document.getElementById('elColectivo');
                 const miDiv2 = document.getElementById('individual');
                 const seleccion1 = parseInt(this.value, 10); // Convertir el valor a número entero
                 console.log(seleccion1); // Usar console.log para depuración

                 // INDIVIDUAL=1, COLECTIVO=2, SEDES RESIDENCIAS=3.
                 if (seleccion1 === 1) {
                     miDiv1.style.display = 'none';
                     miDiv2.style.display = 'block';
                 } else {
                     miDiv1.style.display = 'block';
                     miDiv2.style.display = 'none';
                 }
             });

              // Llamar a datoCiiu si es necesario para inicializar los valores
              datoCiiu();
            });
            
             function datoCiiu() {
                 // Obtener el valor del select
                 var cod = document.getElementById("id_ciudad").value;
                 document.getElementById("municipio").value = cod;

                 // Obtener el texto del select
                 var combo = document.getElementById("id_ciudad");
                 var selected = combo.options[combo.selectedIndex].text;
                 document.getElementById("nommunicipio").value = selected;
             }
             
            function calcularTotal() {
                     // Obtener los valores de los campos de entrada
                     const cantidadHombres = parseFloat(document.getElementById('cantidad_hombres').value) || 0;
                     const cantidadMujeres = parseFloat(document.getElementById('cantidad_mujeres').value) || 0;
                     const cantidadBinarios = parseFloat(document.getElementById('cantidad_binarios').value) || 0;
                    
                    // window.alert (cantidadHombres);
                    // window.alert (cantidadMujeres);
                    // window.alert (cantidadBinarios);
                     
                     // Calcular la suma
                      const totalPersonas = cantidadHombres + cantidadMujeres + cantidadBinarios;
                    //  window.alert (totalPersonas);

                     // Actualizar el campo de resultado
                     document.getElementById('no_personas_evaluar').value = totalPersonas;
             }
             
             function confirmarBeneficiario(){
                 if(confirm('¿Estas seguro de eliminar el beneficiario del colectivo?'))
                   return true;
                 else
                   return false;
             }
            
          </script>

          <style>
              #emergencia {
               display: none; /* Inicialmente visible */
              }
              #elColectivo {
               display: none; /* Inicialmente visible */
              }
       </style>
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
    
    
    if(isset($_POST['borrarBeneficiario']))
    {
       $borrarBen  = $_POST['borrarBeneficiario'];
       $partir  = explode ("-", $borrarBen);   
       
       $s_registro     = $partir[0];
       $no_documento_ben_colectivo     = $partir[1];
       
       // Consulta preparada con marcadores de posición
        $sql = "DELETE FROM graerr_colectivo WHERE registro = :registro AND no_documento_ben_colectivo = :no_documento_ben_colectivo ";
        
       // Preparar la consulta
       $stmt = $pdo->prepare($sql);
        
       // Asignar valores a los marcadores de posición
       $stmt->bindParam(':registro', $s_registro, PDO::PARAM_INT);
       $stmt->bindParam(':no_documento_ben_colectivo', $no_documento_ben_colectivo, PDO::PARAM_INT);

       // Ejecutar la consulta
       if ($stmt->execute()) {
             $mensaje=" <b>Atención!</b> Se elimino el beneficiario de forma exitosa";
             //echo "Se eliminó el registro correctamente.";
       } else {
             echo "Error al intentar eliminar el registro.";
       }
       
       $s_existe              = $_POST['existe'];
       $s_yaGrabo             = $_POST['yaGrabo'];
         
    }   // borrarBeneficiario
    
    
    if ( $s_registro != "" )
    {  
             ///////////////////////////////////////////////////////  
             ////// REALIZA LA CONSULTA  
             $titulo = "MODIFICAR REGISTRO";
             $s_existe = 1;
             $boton  = "Actualizar";
    
             $sql = "select * from graerr_formulario_b where registro=$s_registro";
             $stmt = $pdo->query($sql);
             $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      
             $s_registro                    = $row['registro'];
             $registro                      = $row['registro'];
             $vigencia                      = $row['vigencia'];
             $fecha_recepcion_unp           = $row['fecha_recepcion_unp'];
             $fecha_recepcion_graerr        = $row['fecha_recepcion_graerr'];
             $fecha_carta_solicitante       = $row['fecha_carta_solicitante'];
             $no_mem_ext                    = $row['no_mem_ext'];
             $otras_entradas_sigob          = $row['otras_entradas_sigob'];
             $no_folios                     = $row['no_folios'];
             $entidad_persona_solicitante   = $row['entidad_persona_solicitante'];
             $destinatario                  = $row['destinatario'];
             $tipo_documento                = $row['tipo_documento'];
             $no_documento                  = $row['no_documento'];
             $nombres_peticionario          = $row['nombres_peticionario'];
             $apellidos_peticionario        = $row['apellidos_peticionario'];
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
             $seguimiento                   = $row['seguimiento'];
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
             $factor_diferencial            = $row['factor_diferencial'];
             $cantidad_hombres              = $row['cantidad_hombres'];
             $cantidad_mujeres              = $row['cantidad_mujeres'];
             $cantidad_binarios             = $row['cantidad_binarios'];
             
             //Realiza la validació del tipo de ruta y si es tramite de emergencia
             
             //tipo_ruta
             if ($tipo_ruta==1) //Individual
             {
                $prendeColectivo = "display: none;"; 
             }
             
             if ($tipo_ruta==2) //Colectivo
             {
                $prendeColectivo = "display: block;";  
             }
             
             if ($tipo_ruta==3) //Sedes Residencias
             {
                $prendeColectivo = "display: none;";   
             }
             
             //es_tramite_emergencia
             if ($es_tramite_emergencia=="no" or $es_tramite_emergencia=="n")
             {
               $prendeEmergencia = "display: none;";   
               $siTramite = "";
               $noTramite = "selected";
             }
             
             if ($es_tramite_emergencia=="si")
             {
               $prendeEmergencia = "display: block;";
               $siTramite = "selected";
               $noTramite = "";
             }
          
    /*         
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
      */
             
    }  
    else
    {
      $titulo = "NUEVO REGISTRO GRAERR";
      $s_existe = 0;
      $boton="Grabar";
      
      /*
        // GENERA EL NUMERO DEL NUEVO REGISTRO
        $sql = "SELECT MAX(registro) AS maximo FROM graerr_formulario_b";
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
    */    
    }  
 
   
   if(isset($_POST['grabar']))
   { 
             $s_existe         = $_POST['existe'];
             $s_yaGrabo        = $_POST['yaGrabo'];
             date_default_timezone_set('America/Bogota');
             //$s_fecha  = date("Y-m-d",time());
             //$s_fecha  = date("Y/m/d H:i:s");
             $date_added=date("Y-m-d H:i:s");
             
             $s_registro                    = $_POST['registro'];
             $registro                      = $_POST['registro'];
             $vigencia                      = $_POST['vigencia'];
             $fecha_recepcion_unp           = $_POST['fecha_recepcion_unp'];
             $fecha_recepcion_graerr        = $_POST['fecha_recepcion_graerr'];
             $fecha_carta_solicitante       = $_POST['fecha_carta_solicitante'];
             $no_mem_ext                    = trim($_POST['no_mem_ext']);
             $otras_entradas_sigob          = trim($_POST['otras_entradas_sigob']);
             $no_folios                     = $_POST['no_folios'];
             $entidad_persona_solicitante   = trim($_POST['entidad_persona_solicitante']);
             $destinatario                  = trim($_POST['destinatario']);
             $tipo_documento                = $_POST['tipo_documento'];
             $no_documento                  = $_POST['no_documento'];
             $nombres_peticionario          = trim($_POST['nombres_peticionario']);
             $apellidos_peticionario        = trim($_POST['apellidos_peticionario']);
             $seudonimo                     = trim($_POST['seudonimo']);
             $tipo_ruta                     = $_POST['tipo_ruta'];
             $descripcion_colectivo         = trim($_POST['descripcion_colectivo']);
             $nombre_colectivo              = trim($_POST['nombre_colectivo']);
             $no_personas_evaluar           = $_POST['no_personas_evaluar'];
             $genero                        = $_POST['genero'];
             $grupo_etnico                  = $_POST['grupo_etnico'];
             $correo_electronico            = trim($_POST['correo_electronico']);
             $no_de_contacto                = $_POST['no_de_contacto'];
             $otros_numeros_contacto        = $_POST['otros_numeros_contacto'];
             $direccion                     = trim($_POST['direccion']);
             $departamento                  = $_POST['departamento'];
             $municipio                     = $_POST['municipio'];
             $corregimiento_vereda          = trim($_POST['corregimiento_vereda']);
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
             $seguimiento                   = $_POST['seguimiento'];
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
             $factor_diferencial            = $_POST['factor_diferencial'];
             $cantidad_hombres              = $_POST['cantidad_hombres'];
             $cantidad_mujeres              = $_POST['cantidad_mujeres'];
             $cantidad_binarios             = $_POST['cantidad_binarios'];
             
             //PONE TODO EN MAYUSCULAS
             $no_mem_ext                   = strtoupper($no_mem_ext);
             $entidad_persona_solicitante  = strtoupper($entidad_persona_solicitante);
             $destinatario                 = strtoupper($destinatario);
             $nombres_peticionario         = strtoupper($nombres_peticionario);    
             $apellidos_peticionario       = strtoupper($apellidos_peticionario);
             $seudonimo                    = strtoupper($seudonimo);
             $descripcion_colectivo        = strtoupper($descripcion_colectivo);
             $nombre_colectivo             = strtoupper($nombre_colectivo);
             $direccion                    = strtoupper($direccion);
             $corregimiento_vereda         = strtoupper($corregimiento_vereda);
             $recomendacion_riesgo_premesa = strtoupper($recomendacion_riesgo_premesa);
             $observaciones                = strtoupper($observaciones);
             $otros                        = strtoupper($otros);
             
             // asigna valores vacios a las fechas que lo requieren
             if ($fecha_recepcion_unp === "") {
                 $fecha_recepcion_unp = '0000-00-00'; // o
                 $fecha_recepcion_unp = null; 
             }
             
             if ($fecha_recepcion_graerr === "") {
                 $fecha_recepcion_graerr = '0000-00-00'; // o
                 $fecha_recepcion_graerr = null; 
             }
             
             if ($fecha_carta_solicitante === "") {
                 $fecha_carta_solicitante = '0000-00-00'; // o
                 $fecha_carta_solicitante = null; 
             }
             
             if ($fecha_asignado_ot === "") {
                 $fecha_asignado_ot = '0000-00-00'; // o
                 $fecha_asignado_ot = null; 
             }
             
             if ($fecha_reasignacion_ot === "") {
                 $fecha_reasignacion_ot = '0000-00-00'; // o
                 $fecha_reasignacion_ot = null; 
             }
             
             if ($fecha_aprobacion_calidad === "") {
                 $fecha_aprobacion_calidad = '0000-00-00'; // o
                 $fecha_aprobacion_calidad = null; 
             }
             
             if ($fecha_presentacion_premesa === "") {
                 $fecha_presentacion_premesa = '0000-00-00'; // o
                 $fecha_presentacion_premesa = null; 
             }

             //Realiza la validación del tipo de ruta y si es tramite de emergencia
                           
             //tipo_ruta
             if ($tipo_ruta==1) //Individual
             {
                $prendeColectivo = "display: none;"; 
                $descripcion_colectivo = 'N/A';
                $nombre_colectivo = 'N/A';
             }
             
             if ($tipo_ruta==2) //Colectivo
             {
                $prendeColectivo = "display: block;";  
                $apellidos_peticionario ='N/A';
             }
             
             if ($tipo_ruta==3) //Sedes Residencias
             {
                $prendeColectivo = "display: none;";   
                $descripcion_colectivo = '';
                $nombre_colectivo = '';
             }
             
              //es_tramite_emergencia
             if ($es_tramite_emergencia=="no" or $es_tramite_emergencia=="n")
             {
               $prendeEmergencia = "display: none;";   
               $siTramite = "";
               $noTramite = "selected";
             }
             
             if ($es_tramite_emergencia=="si")
             {
               $prendeEmergencia = "display: block;";
               $siTramite = "selected";
               $noTramite = "";
             }
             
   
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
     
    //MODIFICA
    if ($s_existe == "1")  
    {
        try {
            // Conectar a la base de datos
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparar la consulta SQL para actualizar
            $stmt = $pdo->prepare('
            UPDATE graerr_formulario_b
            SET 
                registro = ?, vigencia = ?, fecha_recepcion_unp = ?, fecha_recepcion_graerr = ?, fecha_carta_solicitante = ?,
                no_mem_ext = ?, otras_entradas_sigob = ?, no_folios = ?, entidad_persona_solicitante = ?, destinatario = ?,
                tipo_documento = ?, no_documento = ?, nombres_peticionario = ?, apellidos_peticionario = ?, seudonimo = ?,
                tipo_ruta = ?, descripcion_colectivo = ?, nombre_colectivo = ?, no_personas_evaluar = ?, genero = ?,
                grupo_etnico = ?, factor_diferencial = ?, correo_electronico = ?, no_de_contacto = ?, otros_numeros_contacto = ?,
                direccion = ?, departamento = ?, municipio = ?, corregimiento_vereda = ?, autoriza_envio_info = ?,
                fecha_asignacion_analisis = ?, analista_solicitudes = ?, estado_solicitud = ?, fecha_asignado_ot = ?, 
                fecha_reasignacion_ot = ?, medidas_preventivas = ?, estado_ot = ?, ot = ?, analista_riesgo = ?, 
                analista_riesgo_dos = ?, analista_calidad = ?, subpoblacion = ?, tipo_estudio_riesgo = ?, seguimiento = ?, 
                es_tramite_emergencia = ?, tramite_emergencia = ?, fecha_tramite_emergencia = ?, ingreso_calidad = ?, 
                fecha_aprobacion_calidad = ?, fecha_presentacion_premesa = ?, recomendacion_riesgo_premesa = ?, 
                recomendacion_medidas_premesa = ?, observaciones_premesa = ?, remision_mesa_tecnica = ?, 
                observaciones = ?, otros = ?, cantidad_hombres = ?, cantidad_mujeres = ?, cantidad_binarios = ?
            WHERE registro = ?
        ');

        // Ejecutar la consulta con los valores correspondientes
        $stmt->execute([
            $registro, $vigencia, $fecha_recepcion_unp, $fecha_recepcion_graerr, $fecha_carta_solicitante,
            $no_mem_ext, $otras_entradas_sigob, $no_folios, $entidad_persona_solicitante, $destinatario,
            $tipo_documento, $no_documento, $nombres_peticionario, $apellidos_peticionario, $seudonimo, $tipo_ruta,
            $descripcion_colectivo, $nombre_colectivo, $no_personas_evaluar, $genero, $grupo_etnico,
            $factor_diferencial, $correo_electronico, $no_de_contacto, $otros_numeros_contacto, $direccion,
            $departamento, $municipio, $corregimiento_vereda, $autoriza_envio_info, $fecha_asignacion_analisis,
            $analista_solicitudes, $estado_solicitud, $fecha_asignado_ot, $fecha_reasignacion_ot, $medidas_preventivas,
            $estado_ot, $ot, $analista_riesgo, $analista_riesgo_dos, $analista_calidad, $subpoblacion, $tipo_estudio_riesgo,
            $seguimiento, $es_tramite_emergencia, $tramite_emergencia, $fecha_tramite_emergencia, $ingreso_calidad,
            $fecha_aprobacion_calidad, $fecha_presentacion_premesa, $recomendacion_riesgo_premesa,
            $recomendacion_medidas_premesa, $observaciones_premesa, $remision_mesa_tecnica, $observaciones, $otros, 
            $cantidad_hombres, $cantidad_mujeres, $cantidad_binarios, 
            $registro  // El ID del registro que se actualiza
        ]);
    
           $mensaje=" <b>Atención!</b> Actualización exitosa";
           //echo "Datos actualizados correctamente.";
        } catch (PDOException $e) {
            echo "Error al actualizar los datos: " . $e->getMessage();
        }
    }//modificar
      
    ///ADICIONA
    if ($s_existe == "0")
    {
          echo "NUEVO";
    echo '<br>';
       try {
                // Conectar a la base de datos
                //$conn = new PDO("pgsql:host=localhost;dbname=mi_base_de_datos", "mi_usuario", "mi_contraseña");
                //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                // GENERA EL NUMERO DEL NUEVO REGISTRO
                $sql = "SELECT MAX(registro) AS maximo FROM graerr_formulario_b";
                // echo '<br>';
                //echo $sql;
                //echo '<br>';
                $stmt = $pdo->query($sql);
                $row  = $stmt->fetch(PDO::FETCH_ASSOC);
                $s_maximo = $row['maximo'];
        
                $s_registro = $s_maximo+1; //variable interna
                $registro   = $s_registro;
                //echo '<br>';
                //echo "el regi..·" . $s_registro;
                //echo '<br>';

                // Preparar la consulta SQL
                $stmt = $pdo->prepare('INSERT INTO graerr_formulario_b (
                        registro, vigencia, fecha_recepcion_unp, fecha_recepcion_graerr, fecha_carta_solicitante,
                        no_mem_ext, otras_entradas_sigob, no_folios, entidad_persona_solicitante, destinatario,
                        tipo_documento, no_documento, nombres_peticionario, apellidos_peticionario, seudonimo, 
                        tipo_ruta, descripcion_colectivo, nombre_colectivo, no_personas_evaluar, genero,
                        grupo_etnico, factor_diferencial, correo_electronico, no_de_contacto, otros_numeros_contacto, 
                        direccion, departamento, municipio, corregimiento_vereda, autoriza_envio_info,
                        fecha_asignacion_analisis, analista_solicitudes, estado_solicitud, fecha_asignado_ot, fecha_reasignacion_ot, 
                        medidas_preventivas, estado_ot, ot, analista_riesgo, analista_riesgo_dos,
                        analista_calidad, subpoblacion, tipo_estudio_riesgo, seguimiento, es_tramite_emergencia, 
                        tramite_emergencia, fecha_tramite_emergencia, ingreso_calidad, fecha_aprobacion_calidad, fecha_presentacion_premesa,
                        recomendacion_riesgo_premesa, recomendacion_medidas_premesa, observaciones_premesa, remision_mesa_tecnica, observaciones, 
                        otros, cantidad_hombres, cantidad_mujeres, cantidad_binarios	           
                      ) VALUES (?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?,
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?, ?, 
                                ?, ?, ?, ?)');

                // Ejecutar la consulta con los valores correspondientes
                $stmt->execute([
                       $registro, $vigencia, $fecha_recepcion_unp, $fecha_recepcion_graerr, $fecha_carta_solicitante,
                       $no_mem_ext, $otras_entradas_sigob, $no_folios, $entidad_persona_solicitante, $destinatario,
                       $tipo_documento, $no_documento, $nombres_peticionario, $apellidos_peticionario, $seudonimo, 
                       $tipo_ruta, $descripcion_colectivo, $nombre_colectivo, $no_personas_evaluar, $genero,
                       $grupo_etnico, $factor_diferencial, $correo_electronico, $no_de_contacto, $otros_numeros_contacto, 
                       $direccion, $departamento, $municipio, $corregimiento_vereda, $autoriza_envio_info,
                       $fecha_asignacion_analisis, $analista_solicitudes, $estado_solicitud, $fecha_asignado_ot, $fecha_reasignacion_ot, 
                       $medidas_preventivas, $estado_ot, $ot, $analista_riesgo, $analista_riesgo_dos,
                       $analista_calidad, $subpoblacion, $tipo_estudio_riesgo, $seguimiento, $es_tramite_emergencia, 
                       $tramite_emergencia, $fecha_tramite_emergencia, $ingreso_calidad, $fecha_aprobacion_calidad, $fecha_presentacion_premesa,
                       $recomendacion_riesgo_premesa, $recomendacion_medidas_premesa, $observaciones_premesa, $remision_mesa_tecnica, $observaciones, 
                       $otros, $cantidad_hombres, $cantidad_mujeres , $cantidad_binarios	           
                      ]);              
                   
                      $mensaje=" <b>Atención!</b> Grabación exitosa ¡";        
                    //echo "Datos insertados correctamente.";
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
      if ($line['id']==$factor_diferencial)
      {
        $combo_factor_diferencial .=" <option value='".$line['id']."' selected>".$line['factor_diferencial']." </option>"; 
      }
      $combo_factor_diferencial .=" <option value='".$line['id']."'>".$line['factor_diferencial']."</option>"; 
      $i++; 
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
   
    //============================= CONSULTA EL graerr_genero
    //============================================================================ 
    $stmt = $pdo->query('select * from graerr_genero order by id');
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
        $combo_vigencia .=" <option value=''>".'- Seleccione la vigencia -'."</option>";
      }
      if ($line['ano']==$vigencia)
      {
        $combo_vigencia .=" <option value='".$line['ano']."' selected>".$line['ano']." </option>"; 
      }
       $combo_vigencia .=" <option value='".$line['ano']."'>".$line['ano']."</ano>"; 
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
                         <a href="graerrFormulario0.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
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
                   <div class="container-fluid" style="margin-bottom:10px;">
                        
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
                  </div>
                </div> <!-- panel body -->	 
              
               <div class="modal-footer"> 
                <div class="col-sm-11" align="center">  
                   <?php
                     echo '<br>'; 
                     echo "el boton.." . $boton;
                     echo '<br>';
                   ?>
                  <button type="submit" name='grabar' class="btn btn-md btn-success btn-lg"><i class="glyphicon glyphicon-refresh"></i> <?=$boton?> </button>
                </div>	 
              </div>
         
             <input style="visibility:hidden" name="registro" id="registro" value="<?=$s_registro?>"/>
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
      <script>
        // Espera a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function() {
            const miSelect = document.getElementById('es_tramite_emergencia');
            const miDiv = document.getElementById('emergencia');

            miSelect.addEventListener('change', function() {
                const seleccion = this.value;

                if (seleccion === 'no') {
                    miDiv.style.display = 'none';
                } else {
                    miDiv.style.display = 'block';
                }
            });
        });
      </script>
      
      <script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
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
  
   