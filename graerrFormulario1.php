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
    // require("modal.php");
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
                      document.getElementById("descripcion_colectivo").setAttribute("readonly", "readonly");
                      document.getElementById("nombre_colectivo").setAttribute("readonly", "readonly");
                      document.getElementById("nombres_peticionario").removeAttribute("readonly");
                      document.getElementById("apellidos_peticionario").removeAttribute("readonly");
                      document.getElementById("seudonimo").removeAttribute("readonly");

                     
                     miDiv1.style.display = 'none';
                     miDiv2.style.display = 'block';
                 } else {
                      document.getElementById("nombres_peticionario").setAttribute("readonly", "readonly");
                      document.getElementById("apellidos_peticionario").setAttribute("readonly", "readonly");
                      document.getElementById("seudonimo").setAttribute("readonly", "readonly");
                      document.getElementById("descripcion_colectivo").removeAttribute("readonly");
                      document.getElementById("nombre_colectivo").removeAttribute("readonly");
                      
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
             
             function concatenarDir() {
                    // const addressType = document.getElementById('addressType').value;
                   // const ruralType = document.getElementById('ruralType') ? document.getElementById('ruralType').value : '';
                   // const urbanoType = document.getElementById('urbanoType') ? document.getElementById('urbanoType').value : '';
                    const tipo_via = document.getElementById('tipo_via') ? document.getElementById('tipo_via').value : '';
                    const num_via_principal = document.getElementById('num_via_principal') ? document.getElementById('num_via_principal').value : '';
                    const letra_via_principal = document.getElementById('letra_via_principal') ? document.getElementById('letra_via_principal').value : '';
                    const prefijo_bis_via_principal = document.getElementById('prefijo_bis_via_principal') ? document.getElementById('prefijo_bis_via_principal').value : '';
                    
                    const cuadrante = document.getElementById('cuadrante') ? document.getElementById('cuadrante').value : '';
                    const via_generadora = document.getElementById('via_generadora') ? document.getElementById('via_generadora').value : '';
                    const letra_via_generadora = document.getElementById('letra_via_generadora') ? document.getElementById('letra_via_generadora').value : '';
                    const sufijo = document.getElementById('sufijo') ? document.getElementById('sufijo').value : '';
                    const letra_sufijo = document.getElementById('letra_sufijo') ? document.getElementById('letra_sufijo').value : '';
                    const numero_placa = document.getElementById('numero_placa') ? document.getElementById('numero_placa').value : '';
                    const cuadrante_numero_placa = document.getElementById('cuadrante_numero_placa') ? document.getElementById('cuadrante_numero_placa').value : '';
                    //const complemento = document.getElementById('complemento').value;
                    const corregimiento_vereda = document.getElementById('corregimiento_vereda') ? document.getElementById('corregimiento_vereda').value : '';

                    let concatenatedInfo = '';
                    
                    //alert("entra11111");
                    
                    // Verifica si cada campo no está vacío antes de concatenar
                    //if (addressType) {
                    //    concatenatedInfo += `${addressType}`;
                    //}

                    //if (ruralType) {
                    //    concatenatedInfo += concatenatedInfo ? ` ${ruralType}` : `${ruralType}`;
                    //}

                    //if (urbanoType) {
                    //    concatenatedInfo += concatenatedInfo ? ` ${urbanoType}` : `${urbanoType}`;
                    //}

                    if (tipo_via) {
                        concatenatedInfo += concatenatedInfo ? ` ${tipo_via}` : `${tipo_via}`;
                    }
                    
                    if (num_via_principal) {
                        concatenatedInfo += concatenatedInfo ? ` ${num_via_principal}` : `${num_via_principal}`;
                    }
                    
                    if (letra_via_principal) {
                        concatenatedInfo += concatenatedInfo ? ` ${letra_via_principal}` : `${letra_via_principal}`;
                    }
                    
                    if (prefijo_bis_via_principal) {
                        concatenatedInfo += concatenatedInfo ? ` ${prefijo_bis_via_principal}` : `${prefijo_bis_via_principal}`;
                    }
                    
                    
                    if (cuadrante) {
                        concatenatedInfo += cuadrante ? ` ${cuadrante}` : `${cuadrante}`;
                    }
                    
                    
                    if (via_generadora) {
                        concatenatedInfo += concatenatedInfo ? ` ${via_generadora}` : `${via_generadora}`;
                    }
                    
                    if (letra_via_generadora) {
                        concatenatedInfo += concatenatedInfo ? ` ${letra_via_generadora}` : `${letra_via_generadora}`;
                    }
                    
                    if (sufijo) {
                        concatenatedInfo += concatenatedInfo ? ` ${sufijo}` : `${sufijo}`;
                    }
                    
                    if (letra_sufijo) {
                        concatenatedInfo += concatenatedInfo ? ` ${letra_sufijo}` : `${letra_sufijo}`;
                    }
                    
                    if (numero_placa) {
                        concatenatedInfo += concatenatedInfo ? ` ${numero_placa}` : `${numero_placa}`;
                    }
                    
                    if (cuadrante_numero_placa) {
                        concatenatedInfo += concatenatedInfo ? ` ${cuadrante_numero_placa}` : `${cuadrante_numero_placa}`;
                    }
                    
                   // if (complemento) {
                   //        concatenatedInfo += concatenatedInfo ? ` ${complemento}` : `${complemento}`;
                   // }
                    
                   if (corregimiento_vereda) {
                       concatenatedInfo += concatenatedInfo ? ` ${corregimiento_vereda}` : `${corregimiento_vereda}`;
                   }

                    // Si concatenatedInfo no está vacío, muestra la alerta
                    if (concatenatedInfo) {
                       // alert(concatenatedInfo);
                        document.getElementById('direccion').value = concatenatedInfo;
                    }
             }  
          </script>

          <style>
              #emergencia {
               display: none; /* Inicialmente visible */
              }
              #elColectivo {
               display: none; /* Inicialmente visible */
              }
              
            .modal-content {
                border-radius: 8px;
            }
            .modal-header {
                border-bottom: none;
            }
            .modal-footer {
                border-top: none;
            }
        
            .custom-modal-dialog {
                max-width: 80%; /* Ajusta el valor según el ancho deseado */
            }
        
            .labelDireccion {
               font-weight: bold;          /* Establece el texto en negrita */
               font-family: Arial, sans-serif; /* Usa la fuente Arial o sans-serif como alternativa */
               font-size: 12px;            /* Tamaño de fuente de 12px */
               text-align: center;         /* Centra el texto */
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
            
             //trae los datos e la direccion
             $sql1 = "select * from graerr_direccion where registro=$s_registro";
             $stmt1 = $pdo->query($sql1);
             $row1  = $stmt1->fetch(PDO::FETCH_ASSOC);
             
             $addressType                  = $row1['addresstype'];                     
             $ruralType                    = $row1['ruraltype'];
             $urbanoType                   = $row1['urbanotype'];
             $tipo_via                     = $row1['tipo_via'];
             $num_via_principal             = $row1['num_via_principal'];
             $letra_via_principal           = $row1['letra_via_principal'];
             $prefijo_bis_via_principal     = $row1['prefijo_bis_via_principal'];
             $cuadrante                     = $row1['cuadrante'];
             $via_generadora                = $row1['via_generadora'];
             $letra_via_generadora          = $row1['letra_via_generadora']; 
             $sufijo                       = $row1['sufijo'];
             $letra_sufijo                 = $row1['letra_sufijo'];
             $numero_placa                 = $row1['numero_placa'];
             $cuadrante_numero_placa       = $row1['cuadrante_numero_placa'];
             $complemento                  = $row1['complemento'];
             
              
            //prefijo Y DATOS DE DIRECCION
            if ($prefijo_bis_via_principal==""){
                $prevgfN="selected";
                $prevgfS="";
             }
             else
             {
                $prevgfS="selected"; 
                $prevgfN="";
             }
             
            //SUFIJO Y DATOS DE DIRECCION
            if ($sufijo==""){
                $sufN="selected";
                $sufS="";
             }
             else
             {
                $sufS="selected"; 
                $sufN="";
             }
             
             if ($addressType=='rural'){
                 $aTr = 'selected';
                 $aTu = '';
                 $eltipodireccion="Rural";
             }
             if ($addressType=='urbano'){
                $aTr = '';
                $aTu = 'selected'; 
                $eltipodireccion="Urbano";
             }
            
             if ($ruralType != ""){
                $urbanoType = "";
                $tipoRuralUrbano="Tipo Rural";
                
                 if ($ruralType == "corregimiento"){
                     $rsCor = "selected";
                     $rsCp  = '';
                     $rsVe  = '';
                     $rsOt  = '';
                     $nomtipodireccion = "Corregimiento";
                 }
                 if ($ruralType == "centro_poblado"){
                     $rsCor = '';
                     $rsCp  = 'selected';
                     $rsVe  = '';
                     $rsOt  = '';
                     $nomtipodireccion = "Centro Poblado";
                 }
                 if($ruralType == "vereda"){
                     $rsCor = '';
                     $rsCp  = '';
                     $rsVe  = 'selected';
                     $rsOt  = ''; 
                     $nomtipodireccion = "Vereda";
                 }
                 if($ruralType == "otro"){
                     $rsCor = '';
                     $rsCp  = '';
                     $rsVe  = '';
                     $rsOt  = 'selected';  
                     $nomtipodireccion = "Otro";
                 }
             }
             else{
                if($urbanoType!=""){
                   $ruralType = "";
                   $tipoRuralUrbano="Tipo Urbano";  
                   if($urbanoType=="tipo_via"){
                       $uTv="selected";
                       $uBa='';
                       $uCa='';
                       $nomtipodireccion = "Tipo de Vía";
                   }
                   if($urbanoType=="barrio"){
                      $uTv="";
                      $uBa='selected';
                      $uCa=''; 
                      $nomtipodireccion = "Barrio";
                   }
                   if($urbanoType=="campo_abierto"){
                      $uTv="";
                      $uBa='';
                      $uCa='selected'; 
                      $nomtipodireccion = "Campo Abierto";
                   }
                }
             }    
             
             //Realiza la validación del tipo de ruta y si es tramite de emergencia
             
             //tipo_ruta
             if ($tipo_ruta==1) //Individual
             {
                $prendeColectivo = "display: none;"; 
                $enciendeColectivo = "readonly";
                $enciendeIndividual = "";
                $descripcion_colectivo = 'N/A';
                $nombre_colectivo = 'N/A';
             }
             
             if ($tipo_ruta==2) //Colectivo
             {
                $prendeColectivo = "display: block;";  
                $enciendeColectivo = "";
                $enciendeIndividual = "readonly";
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
      
      //inicializa valores numericos en 0
      
      $otros_numeros_contacto = 0;
      $cantidad_hombres       = 0;
      $cantidad_mujeres       = 0;
      $cantidad_binarios      = 0;
      $no_folios              = 0;
        
      
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
             $observaciones                 = trim($_POST['observaciones']);
             $otros                         = trim($_POST['otros']);
             $factor_diferencial            = $_POST['factor_diferencial'];
             $cantidad_hombres              = $_POST['cantidad_hombres'];
             $cantidad_mujeres              = $_POST['cantidad_mujeres'];
             $cantidad_binarios             = $_POST['cantidad_binarios'];
             
             //PONE TODO EN MAYUSCULAS
             $no_mem_ext                   = strtoupper($no_mem_ext);
             $entidad_persona_solicitante  = strtoupper($entidad_persona_solicitante);
             $otras_entradas_sigob         = strtoupper($otras_entradas_sigob);
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
             
             //TOMA DATOS DE LA DIRECCION
             $addressType                  = $_POST['addressType'];                     
             $ruralType                    = $_POST['ruralType'];
             $urbanoType                   = $_POST['urbanoType'];
             $tipo_via                     = $_POST['tipo_via'];
             $num_via_principal             = $_POST['num_via_principal'];
             $letra_via_principal           = $_POST['letra_via_principal'];
             $prefijo_bis_via_principal     = $_POST['prefijo_bis_via_principal'];
             $cuadrante                    = $_POST['cuadrante'];
             $via_generadora               = $_POST['via_generadora'];
             $letra_via_generadora         = $_POST['letra_via_generadora']; 
             $sufijo                       = $_POST['sufijo'];
             $letra_sufijo                 = $_POST['letra_sufijo'];
             $numero_placa                 = $_POST['numero_placa'];
             $cuadrante_numero_placa       = $_POST['cuadrante_numero_placa'];
             $complemento                  = strtoupper($_POST['corregimiento_vereda']);
       
             //prefijo Y DATOS DE DIRECCION
            if ($prefijo_bis_via_principal==""){
                $prevgfN="selected";
                $prevgfS="";
             }
             else
             {
                $prevgfS="selected"; 
                $prevgfN="";
             }
             
             //SUFIJO
             if ($sufijo==""){
                $sufN="selected";
                $sufS="";
             }
             else
             {
                $sufS="selected"; 
                $sufN="";
             }
             
             // valores para tipo de via
             /*
             echo "ADRESS TIPO: " . $addressType;
             ECHO '<BR>';
             
             echo "ruralType TIPO: " . $ruralType;
             ECHO '<BR>';
             
             echo "urbanoType TIPO: " . $urbanoType;
             ECHO '<BR>';
             
             echo "1.." . $tipo_via;
             ECHO '<BR>';
             echo "2.." . $cuadrante;
             ECHO '<BR>';
             echo "3.." . $via_generadora;
             ECHO '<BR>';
             echo "4.." . $letra_via_generadora;
             ECHO '<BR>';
             echo "5.." . $sufijo;     
             ECHO '<BR>';
             echo "6.." . $letra_sufijo;
             ECHO '<BR>';
             echo "7.." . $numero_placa;
             ECHO '<BR>';
             echo "8.." . $cuadrante_numero_placa;
             ECHO '<BR>';
             echo "9.." . $complemento;
             ECHO '<BR>';
             */
             
             if ($addressType=='rural'){
                 $aTr = 'selected';
                 $aTu = '';
                 $eltipodireccion="Rural";
             }
             if ($addressType=='urbano'){
                $aTr = '';
                $aTu = 'selected'; 
                $eltipodireccion="Urbano";
             }
            
             if ($ruralType != ""){
                $urbanoType = "";
                $tipoRuralUrbano="Tipo Rural";
                
                 if ($ruralType == "corregimiento"){
                     $rsCor = "selected";
                     $rsCp  = '';
                     $rsVe  = '';
                     $rsOt  = '';
                     $nomtipodireccion = "Corregimiento";
                 }
                 if ($ruralType == "centro_poblado"){
                     $rsCor = '';
                     $rsCp  = 'selected';
                     $rsVe  = '';
                     $rsOt  = '';
                     $nomtipodireccion = "Centro Poblado";
                 }
                 if($ruralType == "vereda"){
                     $rsCor = '';
                     $rsCp  = '';
                     $rsVe  = 'selected';
                     $rsOt  = ''; 
                     $nomtipodireccion = "Vereda";
                 }
                 if($ruralType == "otro"){
                     $rsCor = '';
                     $rsCp  = '';
                     $rsVe  = '';
                     $rsOt  = 'selected';  
                     $nomtipodireccion = "Otro";
                 }
             }
             else{
                if($urbanoType!=""){
                   $ruralType = "";
                   $tipoRuralUrbano="Tipo Urbano";  
                   if($urbanoType=="tipo_via"){
                       $uTv="selected";
                       $uBa='';
                       $uCa='';
                       $nomtipodireccion = "Tipo de Vía";
                   }
                   if($urbanoType=="barrio"){
                      $uTv="";
                      $uBa='selected';
                      $uCa=''; 
                      $nomtipodireccion = "Barrio";
                   }
                   if($urbanoType=="campo_abierto"){
                      $uTv="";
                      $uBa='';
                      $uCa='selected'; 
                      $nomtipodireccion = "Campo Abierto";
                   }
                }
             }    
             
             // asigna valores vacios a las fechas que lo requieren
             if ($fecha_recepcion_unp === "") {
                 $fecha_recepcion_unp =  '1900-01-01'; 
             }
             
             if ($fecha_recepcion_graerr === "") {
                 $fecha_recepcion_graerr = '1900-01-01';
             }
             
             if ($fecha_carta_solicitante === "") {
                 $fecha_carta_solicitante = '1900-01-01';
             }
             
             if ($fecha_asignado_ot === "") {
                 $fecha_asignado_ot = '1900-01-01';
             }
             
             if ($fecha_reasignacion_ot === "") {
                 $fecha_reasignacion_ot = '1900-01-01';
             }
             
             
             if ($ingreso_calidad === "") {
                 $ingreso_calidad = '1900-01-01';
             }
             
             if ($fecha_aprobacion_calidad === "") {
                 $fecha_aprobacion_calidad = '1900-01-01';
             }
             
             
             if ($fecha_presentacion_premesa === "") {
                 $fecha_presentacion_premesa = '1900-01-01';
             }
             
             if ($fecha_asignacion_analisis === "") {
                 $fecha_asignacion_analisis = '1900-01-01';
             }
             
             if ($fecha_tramite_emergencia === "") {
                 $fecha_tramite_emergencia = '1900-01-01';
             }
              
             //Realiza la validación del tipo de ruta y si es tramite de emergencia
                           
             //tipo_ruta
             if ($tipo_ruta==1) //Individual
             {
                $prendeColectivo = "display: none;"; 
                $enciendeColectivo = "readonly";
                $enciendeIndividual = "";
                $descripcion_colectivo = 'N/A';
                $nombre_colectivo = 'N/A';
             }
             
             if ($tipo_ruta==2) //Colectivo
             {
                $prendeColectivo = "display: block;";  
                $enciendeColectivo = "";
                $enciendeIndividual = "readonly";
                $apellidos_peticionario ='N/A';
                $seudonimo = "N/A";
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
             
             if ($es_tramite_emergencia=="si" or $es_tramite_emergencia=="s")
             {
               $prendeEmergencia = "display: block;";
               $siTramite = "selected";
               $noTramite = "";
             }
             
   /*
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
     */
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
            echo "Error al actualizar los datos de formulario: " . $e->getMessage();
        }
         
        try {
           $stmt1 = $pdo->prepare('
           UPDATE graerr_direccion
           SET addresstype = ?,
               ruraltype = ?,
               urbanotype = ?,
               tipo_via = ?,
               num_via_principal = ?,
	           letra_via_principal = ?,
	           prefijo_bis_via_principal = ?,
               cuadrante = ?,
               via_generadora = ?,
               letra_via_generadora = ?,
               sufijo = ?,
               letra_sufijo  = ?,
               numero_placa = ?,
               cuadrante_numero_placa = ?,
               complemento = ?
              WHERE registro = ?
           ');

            $stmt1->execute([
                $addressType,
                $ruralType,
                $urbanoType,
                $tipo_via,
                $num_via_principal,
	            $letra_via_principal,
	            $prefijo_bis_via_principal,
                $cuadrante,
                $via_generadora,
                $letra_via_generadora,
                $sufijo,
                $letra_sufijo,
                $numero_placa,
                $cuadrante_numero_placa,
                $complemento,
              $registro  // El ID del registro que se actualiza
            ]);
           //$mensaje=" <b>Atención!</b> Actualización exitosa";
           //echo "Datos actualizados correctamente.";
        } catch (PDOException $e) {
            echo "Error al actualizar los datos de direccion: " . $e->getMessage();
        }
        
    }//modificar
      
    ///ADICIONA
    if ($s_existe == "0")
    {
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
                
                //calcula y conforma nuevo consecutivo de la OT
                //toma el año actual
                $ano_actual = date('Y');
                //consulta el maximo conscutivo
                $sql = "SELECT MAX(consecutivo_ot) AS maximo_te FROM graerr_formulario_b";
                $stmt = $pdo->query($sql);
                $row  = $stmt->fetch(PDO::FETCH_ASSOC);
                $s_maximo = $row['maximo_te'];
        
                $s_nuevo_con_ot = $s_maximo + 1;
                $s_nuevo_ot     = $ano_actual . "-" . $s_nuevo_con_ot;
                $ot = "OT" .$s_nuevo_ot;
                /*
                echo '<br>';
                echo "el ot..·" . $s_nuevo_ot;
                echo '<br>';
                */
                // ¿es tramite de emergencia?
                $s_nuevo_con_te=0;
                if ($es_tramite_emergencia=="si" or $es_tramite_emergencia=="s")
                {
                   //calcula y conforma nuevo consecutivo del tremite de emergencia
                   //toma el año actual
                   $ano_actual = date('Y');
                   echo $ano_actual;
                   //consulta el maximo conscutivo
                   $sql = "SELECT MAX(consecutivo_te) AS maximo_te FROM graerr_formulario_b";
                   $stmt = $pdo->query($sql);
                   $row  = $stmt->fetch(PDO::FETCH_ASSOC);
                   $s_maximo = $row['maximo_te'];
        
                   $s_nuevo_con_te     = $s_maximo + 1;
                   $s_nuevo_te         = $ano_actual . "-" . $s_nuevo_con_te;
                   $tramite_emergencia = "T." . $s_nuevo_te;
                   /*
                   echo '<br>';
                   echo "el te..·" . $s_nuevo_te;
                   echo '<br>';
                   */
                 }
               
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
                        otros, cantidad_hombres, cantidad_mujeres, cantidad_binarios,
                        consecutivo_ot, consecutivo_te
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
                                ?, ?, ?, ?,
                                ?, ?)');

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
                       $otros, $cantidad_hombres, $cantidad_mujeres , $cantidad_binarios, 
                       $s_nuevo_con_ot, $s_nuevo_con_te	           
                      ]);              
                   
                      $mensaje=" <b>Atención!</b> Grabación exitosa ¡";        
                    //echo "Datos insertados correctamente.";
                } catch (PDOException $e) {
            echo "Error al insertar los datos del formulario: " . $e->getMessage();
        }
        
        
        try {
                $stmt1 = $pdo->prepare('
                INSERT INTO graerr_direccion (
                    registro, addresstype, ruraltype, urbanotype, tipo_via, num_via_principal, 
                    letra_via_principal, prefijo_bis_via_principal, cuadrante, via_generadora, letra_via_generadora, 
                    sufijo, letra_sufijo, numero_placa, cuadrante_numero_placa, complemento
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            '); 

            $stmt1->execute([
                $registro,
                $addressType,
                $ruralType,
                $urbanoType,
                $tipo_via,
                $num_via_principal, 
                $letra_via_principal, 
                $prefijo_bis_via_principal,
                $cuadrante,
                $via_generadora,
                $letra_via_generadora,
                $sufijo,
                $letra_sufijo,
                $numero_placa,            
                $cuadrante_numero_placa,
                $complemento
            ]);

            
        } catch (PDOException $e) {
            echo "Error al insertar los datos de la direccion: " . $e->getMessage();
        }
            
         $s_existe ="1";
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
    
    
    //===========================================================
    //===================== MODAL ===============================
    
    
    //============================= MANZANA
    //============================================================================ 
    $stmt = $pdo->query('SELECT id, manzana  FROM graerr_bas_manzana order by manzana');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_manzana .=" <option value=''>".'- Seleccione la manzana -'."</option>";
      }
      
      $combo_manzana .=" <option value='".$line['id']."'>".$line['manzana']."</option>"; 
      $i++; 
    }
    
    //============================= graerr_bas_tipo_predio
    //============================================================================ 
    $stmt = $pdo->query('SELECT id, tipo  FROM graerr_bas_tipo_predio order by tipo');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_tipo_predio .=" <option value=''>".'- Seleccione el tipo de predio -'."</option>";
      }
      
      $combo_tipo_predio .=" <option value='".$line['id']."'>".$line['tipo']."</option>"; 
      $i++; 
    }
    
    //============================= graerr_bas_tipo_predio
    //============================================================================ 
    $stmt = $pdo->query('SELECT id, tipo_via  FROM graerr_bas_tipo_via order by tipo_via');
    
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_tipo_via .=" <option value=''>".'- Seleccione el tipo de via -'."</option>";
      }
      if ($line['id']==$tipo_via)
      {
        $combo_tipo_via .=" <option value='".$line['id']."' selected>".$line['tipo_via']." </option>"; 
      }
      $combo_tipo_via .=" <option value='".$line['id']."'>".$line['tipo_via']."</option>"; 
      $i++; 
    }
   
    //============================= graerr_bas_urbanizacion
    //============================================================================ 
    $stmt = $pdo->query('SELECT id, tipo  FROM graerr_bas_urbanizacion order by tipo');
    
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_urbanizacion .=" <option value=''>".'- Seleccione el tipo urbanización -'."</option>";
      }
      
      $combo_urbanizacion .=" <option value='".$line['id']."'>".$line['tipo']."</option>"; 
      $i++; 
    }
     
    
    //===========================================================
    //===================== MODAL ===============================
    //============================= ALFABETO
    //============================================================================ 
    $stmt = $pdo->query('SELECT letra FROM graerr_bas_alfabeto order by letra');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_via_generadora .=" <option value=''>".'- Seleccione la letra -'."</option>";
      }
      if ($line['letra']==$letra_via_generadora)
      {
        $combo_via_generadora .=" <option value='".$line['letra']."' selected>".$line['letra']." </option>"; 
      }
      
       $combo_via_generadora .=" <option value='".$line['letra']."'>".$line['letra']."</ano>"; 
      $i++; 
    }
    
    //LETRA SUFIJO
    $stmt = $pdo->query('SELECT letra  FROM graerr_bas_alfabeto order by letra');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_letra_sufijo .=" <option value=''>".'- Seleccione la letra -'."</option>";
      }
      if ($line['letra']==$letra_sufijo)
      {
        $combo_letra_sufijo .=" <option value='".$line['letra']."' selected>".$line['letra']." </option>"; 
      }
      
       $combo_letra_sufijo .=" <option value='".$line['letra']."'>".$line['letra']."</ano>"; 
      $i++; 
    }

    //LETRA VIA PRINCIPAL
    $stmt = $pdo->query('SELECT letra  FROM graerr_bas_alfabeto order by letra');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_letra_via_principal .=" <option value=''>".'- Seleccione la letra -'."</option>";
      }
      if ($line['letra']==$letra_via_principal)
      {
        $combo_letra_via_principal .=" <option value='".$line['letra']."' selected>".$line['letra']." </option>"; 
      }
      
       $combo_letra_via_principal .=" <option value='".$line['letra']."'>".$line['letra']."</ano>"; 
      $i++; 
    }

            


    //============================= CUADRANTE
    //============================================================================ 
    $stmt = $pdo->query('SELECT cuadrante  FROM graerr_bas_cuadrante order by cuadrante');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_cuadrante .=" <option value=''>".'- Seleccione el cuadrante -'."</option>";
      }
      if ($line['cuadrante']==$cuadrante)
      {
        $combo_cuadrante .=" <option value='".$line['cuadrante']."' selected>".$line['cuadrante']." </option>"; 
      }
      
       $combo_cuadrante .=" <option value='".$line['cuadrante']."'>".$line['cuadrante']."</ano>"; 
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
                              
                                <select <?=$active?> required class="form-control" id="vigencia" name="vigencia" autofocus>
                                  <?php echo $combo_vigencia; ?>
                                </select>
                           </div>
                           
                           <div class="col-sm-3" align="left">
                               <label for="fecha_recepcion_unp">FECHA DE RECEPCION EN LA UNP</label>
                               <input type="date" class="form-control" id="fecha_recepcion_unp" name="fecha_recepcion_unp"  value="<?=$fecha_recepcion_unp?>" >
                           </div>
                          
                            <div class="col-sm-3" align="left">
                               <label for="fecha_recepcion_graerr">FECHA RECEPCION GRAERR</label>
                               <input type="date" class="form-control" id="fecha_recepcion_graerr" name="fecha_recepcion_graerr"  value="<?=$fecha_recepcion_graerr?>" >
                            </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">
                           <div class="col-sm-3" align="left">
                               <label for="fecha_carta_solicitante">FECHA DE CARTA SOLICITANTE</label>
                               <input type="date" class="form-control" id="fecha_carta_solicitante" name="fecha_carta_solicitante"  value="<?=$fecha_carta_solicitante?>" >
                           </div>
                           
                           <div  class="col-sm-3" align="left">
                               <label for="no_mem_ext">No MEM y/o EXT</label>
                               <input type="text" class="form-control" id="no_mem_ext" name="no_mem_ext"  value="<?=$no_mem_ext?>" required  style="text-transform:uppercase;">
                           </div>
                           
                           <div class="col-sm-3" align="left">
                                <label for="otras_entradas_sigob">OTRAS ENTRADAS SIGOB</label>
                                <input type="text" class="form-control" id="otras_entradas_sigob" name="otras_entradas_sigob"  value="<?=$otras_entradas_sigob?>"  style="text-transform:uppercase;" required>
                            </div>
                            
                            <div class="col-sm-3" align="left">
                                <label for="no_folios">No FOLIOS</label>
                                <input min="0" type="number" class="form-control" id="no_folios" name="no_folios"  value="<?=$no_folios?>" required>
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
                              <label for="tipo_ruta">TIPO DE RUTA</label>
                              <?php echo $tipo_ruta; ?> 
                              <!--<input type="text" class="form-control" id="tipo_ruta" name="tipo_ruta"  value="<?=$tipo_ruta?>">-->
                               <select <?=$active?> required class="form-control" id="tipo_ruta" name="tipo_ruta">
                                 <?php echo $combo_tipo_ruta; ?>
                               </select>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="tipo_documento">TIPO DE DOCUMENTO</label>
                               <!--<input type="text" class="form-control" id="tipo_documento" name="tipo_documento"  value="<?=$tipo_documento?>" required>-->
                               <select <?=$active?> required class="form-control" name="tipo_documento">
                                  <?php echo $combo_tipo_documento; ?>
                               </select> 
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="no_documento">No DE DOCUMENTO</label>
                               <input min="4" type="number" class="form-control" id="no_documento" name="no_documento"  value="<?=$no_documento?>" required>
                           </div>
                       </div> <!--row-->
                       
                       <! --------------------->
                       <!----- INDIVIDUAL ----->
                       <! --------------------->
                      <!--<div id="individual"> -->
                         <div class="row" style="margin-top:5px;">   
                           <div class="col-sm-4" align="left">
                               <label style="font-size:12px;" for="nombres_peticionario">NOMBRES PETICIONARIO O BENEFICIARIO</label>
                               <input  <?=$enciendeIndividual?> style="text-transform:uppercase;" type="text" class="form-control" id="nombres_peticionario" name="nombres_peticionario"  value="<?=$nombres_peticionario?>" required>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label style="font-size:12px;" for="apellidos_peticionario">APELLIDOS PETICIONARIO O BENEFICIARIO</label>
                               <input  <?=$enciendeIndividual?> style="text-transform:uppercase;" type="text" class="form-control" id="apellidos_peticionario" name="apellidos_peticionario"  value="<?=$apellidos_peticionario?>" required>
                           </div>
                           
                           <div class="col-sm-4" align="left">
                               <label for="seudonimo">SEUDONIMO</label>
                               <input  <?=$enciendeIndividual?> style="text-transform:uppercase;" type="text" class="form-control" id="seudonimo" name="seudonimo"  value="<?=$seudonimo?>">
                           </div>
                         </div> <!--row-->  
                        <!--</div>-->
                       
                         
                       <! --------------------->
                       <!----- COLECTIVO  ----->
                       <! --------------------->
                      <!--<div id="elColectivo" style="<?=$prendeColectivo?>">-->
                         <div class="row" style="margin-top:5px;">   
                             <!--aqui-->
                             <div class="col-sm-4" align="left">
                                <label for="descripcion_colectivo">DESCRIPCION DEL COLECTIVO</label>
                                <input <?=$enciendeColectivo?> style="text-transform:uppercase;" type="text" class="form-control" id="descripcion_colectivo" name="descripcion_colectivo"  value="<?=$descripcion_colectivo?>">
                             </div>
                          
                             <div class="col-sm-4" align="left">
                               <label for="nombre_colectivo">NOMBRE COLECTIVO</label>
                               <input  <?=$enciendeColectivo?> style="text-transform:uppercase;" type="text" class="form-control" id="nombre_colectivo" name="nombre_colectivo"  value="<?=$nombre_colectivo?>">
                             </div>  
                             
                         </div>
                       <!--</div> -->
                       <!--- colectivo -->   
                       
                       <div class="row" style="margin-top:5px;">   
                          <div class="col-sm-4" align="left">
                               <label for="no_personas_evaluar">CANTIDAD DE HOMBRES</label>
                               <input min="0" type="number" class="form-control" id="cantidad_hombres" name="cantidad_hombres"  value="<?=$cantidad_hombres?>" required  onchange="calcularTotal()">
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="no_personas_evaluar">CANTIDAD DE MUJERES</label>
                               <input min="0" type="number" class="form-control" id="cantidad_mujeres" name="cantidad_mujeres"  value="<?=$cantidad_mujeres?>" required  onchange="calcularTotal()">
                           </div>
                           <div class="col-sm-4" align="left">
                               <label for="no_personas_evaluar">CANTIDAD DE BINARIOS</label>
                               <input min="0" type="number" class="form-control" id="cantidad_binarios" name="cantidad_binarios"  value="<?=$cantidad_binarios?>" required  oninput="calcularTotal()">
                           </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">   
                           <div class="col-sm-3" align="left">
                               <label for="no_personas_evaluar">No PERSONAS A EVALUAR</label>
                               <input min="0" type="number" class="form-control" id="no_personas_evaluar" name="no_personas_evaluar"  value="<?=$no_personas_evaluar?>" readonly>
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
                              <input style="text-transform:lowercase;" type="email" class="form-control" id="correo_electronico" name="correo_electronico"   value="<?=$correo_electronico?>"required>
                          </div> 
                          <div class="col-sm-4" align="left">
                              <label for="no_contacto">No DE CONTACTO</label>
                              <input min="0" type="number" class="form-control" id="no_de_contacto" name="no_de_contacto"  value="<?=$no_de_contacto?>" required>
                          </div>
                          <div class="col-sm-4" align="left">
                              <label for="otros_numeros_contacto">OTROS NUMEROS DE CONTACTO</label>
                              <input type="number" class="form-control" id="otros_numeros_contacto" name="otros_numeros_contacto"  value="<?=$otros_numeros_contacto?>">
                          </div>
                       </div> <!--row-->
                       
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
                          
                          <!-- 
                            necesito un campo lista  dependiente de otro campo lista, por ejemplo departamanto y ciudad
                         
                          <div class="col-sm-4" align="left">
                              <label for="ciudad">Ciudad:</label>
                              <select required class="form-control"  id="cities1" name="cities1">
                                  <option value="">Seleccione una ciudad</option>
                                  <!-- Opciones de ciudades que se actualizarán mediante AJAX  
                              </select>
                          
                              <!--<label for="municipio">MUNICIPIO</label>
                              <input type="text" class="form-control" id="municipio" name="municipio"  value="<?=$municipio?>" required> 
                          </div>
                           -->
                       </div> <!--row-->
                                        
                       <div class="row" style="margin-top:5px;">  
                       <hr>
                            <div class="col-sm-6">
                               <div>
                                    <label for="addressType">* Tipo de dirección:</label>
                                    <select class="form-control" id="addressType" name="addressType" required onchange="concatenarDir();">
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="">Seleccione una opción</option>
                                        <option value="rural" <?=$aTr?>>Rural</option>
                                        <option value="urbano" <?=$aTu?>>Urbano</option>
                                    </select>
                                </div>
                           </div>
                           
                           <div class="col-sm-6">
                                <div id="ruralOptions" style="display: none;" >
                                     <label class="labelDireccion" for="ruralType">Tipo de rural:</label>
                                     <select class="form-control" id="ruralType" name="ruralType" onchange="concatenarDir();">
                                         <option value="" disabled selected>Selecciona un tipo</option>
                                         <option value="corregimiento" <?=$rsCor?>>Corregimiento</option>
                                         <option value="centro_poblado" <?=$rsCp?>>Centro Poblado</option>
                                         <option value="vereda" <?=$rsVe?>>Vereda</option>
                                         <option value="otro" <?=$rsOt?>>Otro</option>
                                     </select>
                                </div>
                                
                                <div id="urbanoOptions" style="display: none;">
                                    <label for="urbanoType">Tipo de urbano:</label>
                                    <select class="form-control" id="urbanoType" name="urbanoType" onchange="concatenarDir();">
                                        <option value="" disabled selected>Selecciona un tipo</option>
                                        <option value="tipo_via" <?=$uTv?>>Tipo de Vía</option>
                                        <option value="barrio" <?=$uBa?>>Barrio</option>
                                        <option value="campo_abierto" <?=$uCa?>>Campo Abierto</option>
                                    </select>
                                </div>
                            </div> 
                       </div> <!--row-->        
                       
                       <div class="row" style="margin-top:5px;">  
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="eltipodireccion" name="eltipodireccion" value="<?=$eltipodireccion?> " placeholder="Tipo dirección" readonly><br>  
                            </div>
                            
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nomtipodireccion" name="nomtipodireccion" value="<?=$nomtipodireccion?> " placeholder="Tipo dirección" readonly><br>  
                            </div>
                       </div> <!--row-->
                       

                       <div class="row" style="margin-top:5px;"> 
                            <div class="col-sm-2">
                                <label for="tipo_via">* Tipo de vía:</label>
                                <select <?=$active?> required class="form-control" id="tipo_via" name="tipo_via" onchange="concatenarDir();">
                                    <?=$combo_tipo_via?>
                                </select>
                            </div>
                            
                             <div class="col-sm-2">
                                   <label for="num_via_principal">* No. Vía principal:</label>
                                   <input required type="number" class="form-control" id="num_via_principal" name="num_via_principal" min="0" place holder="Vía Principal" value="<?=$num_via_principal?>" oninput="concatenarDir();">
                            </div>
                            
                            <div class="col-sm-2">
                                   <label  for="letra_via_principal">Letra:</label>
                                    <select class="form-control" id="letra_via_principal" name="letra_via_principal" onchange="concatenarDir();">
                                       <?php echo $combo_letra_via_principal;?>
                                    </select>
                            </div> 
                            
                            <div class="col-sm-2">
                                       <label  for="prefijo_bis_via_principal">Prefijo:</label> 
                                       <select class="form-control" id="prefijo_bis_via_principal" name="prefijo_bis_via_principal" onchange="concatenarDir();">
                                          <!-- Opciones del A a la Z -->
                                          <option value="" <?=$prevgfN?>>Seleccione el Prefijo vía principal</option>
                                          <option value="Bis" <?=$prevgfS?> >Bis</option>
                                        </select>          
                            </div>    
                            
                            <div class="col-sm-2">
                                   <label for="cuadrante_tipo_via">Cuadrante:</label> 
                                   <div class="form-group">
                                     <select <?=$active?>  class="form-control" id="cuadrante" name="cuadrante" onchange="concatenarDir();">
                                         <?php echo $combo_cuadrante; ?>
                                      </select>
                                   </div> 
                            </div>
                        </div> <!-- row -->
                        
                       <div class="row" style="margin-top:5px;"> 
                            <div class="col-sm-2">
                                   <label for="via_generadora">* No. inical placa:</label>
                                   <input required type="number" class="form-control" id="via_generadora" name="via_generadora" min="0" place holder="Vía Generadora" value="<?=$via_generadora?>" oninput="concatenarDir();">
                            </div>
                            
                                <div class="col-sm-2">
                                   <label  for="letra_via_generadora">Letra:</label>
                                    <select class="form-control" id="letra_via_generadora" name="letra_via_generadora" onchange="concatenarDir();">
                                       <?php echo $combo_via_generadora;?>
                                    </select>
                                </div> 
                                
                                <div class="col-sm-2">
                                       <label  for="via_generadora">Sufijo:</label> 
                                       <select class="form-control" id="sufijo" name="sufijo" onchange="concatenarDir();">
                                          <!-- Opciones del A a la Z -->
                                          <option value="" <?=$sufN?>>Seleccione el Sufijo</option>
                                          <option value="Bis" <?=$sufS?> >Bis</option>
                                        </select>          
                                </div>
                                
                                <div class="col-sm-2">
                                   <label  for="letra_sufijo">Letra:</label>
                                   <select class="form-control" id="letra_sufijo" name="letra_sufijo" onchange="concatenarDir();">
                                       <?php echo $combo_letra_sufijo;?>
                                    </select>
                                   </div>  
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;"> 
                                <div class="col-sm-2">
                                        <label for="numero_placa">* Número de placa:</label>
                                         <input required type="number" class="form-control" id="numero_placa" name="numero_placa" value="<?=$numero_placa?>" min="0" oninput="concatenarDir();">
                                </div>
                                 
                                <div class="col-sm-2">
                                      <label  for="cuadrante_numero_placa">Cuadrante:</label>
                                      <div class="form-group">
                                          <select <?=$active?> required class="form-control" id="cuadrante_numero_placa" name="cuadrante_numero_placa" onchange="concatenarDir();">
                                            <?php echo $combo_cuadrante; ?>
                                          </select>
                                      </div>
                                </div>
                                
                                <div class="col-sm-8">
                                      <label for="complemento">Complemento:</label>
                                      <!--<textarea  style="text-transform:uppercase;" class="form-control" id="complemento" name="complemento" rows="1" oninput="concatenarDir();">  </textarea>-->
                                      <input  style="text-transform:uppercase;" type="text" class="form-control" id="corregimiento_vereda" name="corregimiento_vereda" value="<?=$corregimiento_vereda?>"  oninput="concatenarDir();">
                                </div>
                         <hr>
                       </div> <!--row-->
                       
                       <!--<div class="row" style="margin-top:5px;">  
                          <div class="col-sm-12" align="left">
                              <label for="corregimiento_vereda">CORREGIMIENTO O VEREDA</label>
                              <input  style="text-transform:uppercase;" type="text" class="form-control" id="corregimiento_vereda" name="corregimiento_vereda" value="<?=$corregimiento_vereda?>" required>
                          </div>
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;">  
                          <div class="col-sm-12" align="left">  
                              <label for="direccion">DIRECCION</label>
                              <input style="text-transform:uppercase;" readonly type="text" class="form-control" id="direccion" name="direccion"  value="<?=$direccion?>" required>
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
                                  <option value="Si">Sí</option>
                                  <option value="No">No</option>
                                  <option value="Si">No reporta</option>
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
                               <label for="medidas_preventivas">MEDIDAS PREVENTIVAS</label>
                               <!--<input type="text" class="form-control" id="medidas_preventivas" name="medidas_preventivas" value="<?=$medidas_preventivas?>">-->
                               <select <?=$active?> required class="form-control" name="medidas_preventivas">
                                  <?php echo $combo_medidas_preventivas; ?>
                               </select>
                           </div>
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
                       </div> <!--row-->
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="fecha_reasignacion_ot">FECHA REASIGNACION OT</label>
                               <input type="date" class="form-control" id="fecha_reasignacion_ot" name="fecha_reasignacion_ot" value="<?=$fecha_reasignacion_ot?>">
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
                               <input type="text" class="form-control" id="ot" name="ot" value="<?=$ot?>" readonly>
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
                                 <?php echo $combo_subpoblacion; ?>
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
                               <select class="form-control" id="es_tramite_emergencia" name="es_tramite_emergencia" required>
                                  <option value="">Seleccione la opción</option>
                                  <option value="si" <?=$siTramite?>>Sí</option>
                                  <option value="no" <?=$noTramite?>>No</option>
                               </select>
                           </div>
                           
                          <div id='emergencia' style="<?=$prendeEmergencia?>"> 
                             <div class="col-sm-4" align="left">
                               <label for="tramite_emergencia">TRAMITE DE EMERGENCIA</label>
                               <input type="text" class="form-control" id="tramite_emergencia" name="tramite_emergencia" value="<?=$tramite_emergencia?>" readonly>
                             </div>
                             <div class="col-sm-4" align="left">
                               <label for="fecha_tramite_emergencia">FECHA TRAMITE DE EMERGENCIA</label>
                               <input type="date" class="form-control" id="fecha_tramite_emergencia" name="fecha_tramite_emergencia" value="<?=$fecha_tramite_emergencia?>">
                             </div>
                           </div>
                         </div>   
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="ingreso_calidad">INGRESO A CALIDAD</label>
                               <input type="date" class="form-control" id="ingreso_calidad" name="ingreso_calidad" value="<?=$ingreso_calidad?>">
                           </div>
                           
                           <div class="col-sm-4" align="left">
                              <label for="fecha_aprobacion_calidad">FECHA APROBACION ASESOR TECNICO CALIDAD</label>
                              <input type="date" class="form-control" id="fecha_aprobacion_calidad" name="fecha_aprobacion_calidad" value="<?=$fecha_aprobacion_calidad?>">
                           </div>
                           <div class="col-sm-4" align="left">
                              <label for="fecha_presentacion_premesa">FECHA PRESENTACION PREMESA</label>
                              <input type="date" class="form-control" id="fecha_presentacion_premesa" name="fecha_presentacion_premesa" value="<?=$fecha_presentacion_premesa?>">
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           
                           <div class="col-sm-6" align="left">
                               <label for="recomendacion_medidas_premesa">RECOMENDACION DE MEDIDAS PREMESA</label>
                               <select <?=$active?>  class="form-control" name="recomendacion_medidas_premesa">
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
         
             <input style="visibility:hidden" name="registro" id="registro" value="<?=$s_registro?>"/>
             <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
             <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
            </form>  
            
            <?php
              if ($no_personas_evaluar > 1 )
              {
            ?>  
                 <div class="panel panel-info">
	               <div class="panel-heading">
        	          <div class="btn-group pull-right">    
        	             <?php 
        	              $lv      = $s_registro."/". $no_documento_ben_colectivo. "/". $ot . "/MOD1234567890qwertyuiopasdfghjkl";
					      $lVDX    = base64_encode($lv);
        	             ?>
          	            <a href="beneficiarioColectivo.php?LA=<?=$lVDX?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus" ></span> Nuevo Beneficiario</a>
	                  </div>
        	          <h4><i class="fas fa-user-friends" style='color:#2f79b9'></i> BENEFICIARIOS DEL COLECTIVO </h4>
	             </div>
	               
	             <div class="panel-body">	
	                  <?php
                        $sql="select * from  graerr_colectivo where registro = $s_registro";
                        //echo '<br>';echo '<br>';echo '<br>';echo '<br>'; 
                        //echo "el sql.." . $sql;
                        //echo '<br>';echo '<br>';echo '<br>';echo '<br>';
                        $stmt = $pdo->query($sql);
                      ?>
                      <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                         <div class="table-responsive">
	                      <table class='tablaResponsive table table-striped table-bordered table-hover'>
	                            <th>No.Registro</th>
					            <th>Documento</th>
  					            <th>Nombres</th>
					            <th>Apellidos</th>
					            <th>Seudonimo</th>
					            <th class='text-center' colspan="4">Acciones</th>   
					            
					             <?php
			                       $i=1;
			                       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			                         $s_registro                   = $row['registro'];
			                         $s_ot                         = $row['ot'];
			                         $tipo_documento_ben_colectivo = $row['tipo_documento_ben_colectivo'];
  			                         $no_documento_ben_colectivo   = $row['no_documento_ben_colectivo'];
  			                         $nombres_ben_colectivo        = $row['nombres_ben_colectivo'];
  			                         $apellidos_ben_colectivo      = $row['apellidos_ben_colectivo'];
  			                         $seudonimo_ben_colectivo      = $row['seudonimo_ben_colectivo'];
			                    
			                         $borrarB = $s_registro . "-" . $no_documento_ben_colectivo;
			                         $lv      = $s_registro."/". $no_documento_ben_colectivo. "/". $ot . "/MOD1234567890qwertyuiopasdfghjkl";
					                 $lVDX    = base64_encode($lv);
    			                 ?>    
    			                 
    			                 <tr>	
  		   			                <td><?php echo $tipo_documento_ben_colectivo; ?></td>
  					                <td><?php echo $no_documento_ben_colectivo; ?></td>
  					                <td><?php echo $nombres_ben_colectivo; ?></td>
  					                <td><?php echo $apellidos_ben_colectivo; ?></td>
  					                <td><?php echo $seudonimo_ben_colectivo; ?></td>
  					       
					                <td class='text-center'>
					                  <a href="beneficiarioColectivo.php?LA=<?=$lVDX?>" class='btn btn-default' title='Editar registro' ><i class="glyphicon glyphicon-edit"></i></a>  
					                  <input class='btn btn-danger btn-sm' type='submit' id='borrarBeneficiario' name='borrarBeneficiario' value='<?=$borrarB?> ' style="color:#D7524E;" onclick='return confirmarBeneficiario()'>  <i class="fa fa-trash" aria-hidden="true"></i>  
					                 </td>  
					              </tr>
					           
					           <?php
                                 }//while
					           ?> 
					         </table>
					      </div>
					      <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                          <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>    
					  </form>    
	             </div> <!-- panel body -->
	        
	        <?php
              }
            ?>
	        
            
        <!---============================= mODAL ===========-->
        
    <div class="container">   
        
     </div> <!-- container -->
            
            
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
      
      
        <!-- Scripts de Bootstrap y jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

     <!-- Script para mostrar opciones según el tipo seleccionado -->
    <script>
        document.getElementById('addressType').addEventListener('change', function() {
            const addressType = this.value;
            const ruralOptions = document.getElementById('ruralOptions');
            const urbanoOptions = document.getElementById('urbanoOptions');

            if (addressType === 'rural') {
                ruralOptions.style.display = 'block';
                urbanoOptions.style.display = 'none';
            } else if (addressType === 'urbano') {
                ruralOptions.style.display = 'none';
                urbanoOptions.style.display = 'block';
            } else {
                ruralOptions.style.display = 'none';
                urbanoOptions.style.display = 'none';
            }
        });

        document.getElementById('saveAddress').addEventListener('click', function() {
            // Obtener los valores de los campos
            const addressType = document.getElementById('addressType').value;
            const ruralType   = document.getElementById('ruralType') ? document.getElementById('ruralType').value : '';
            const urbanoType  = document.getElementById('urbanoType') ? document.getElementById('urbanoType').value : '';
            const tipo_via    = document.getElementById('tipo_via') ? document.getElementById('tipo_via').value : '';

           
            // Mostrar el valor de dirección y tipo seleccionado
            // console.log(`Dirección: ${direccion}`);
            // console.log(`Tipo de dirección: ${addressType}`);
            // console.log(`Tipo rural: ${ruralType}`);
            // nsole.log(`Tipo urbano: ${urbanoType}`);

            // Aquí podrías hacer algo con la dirección, como enviar el formulario o actualizar algún campo

            // Cerrar el modal
            $('#myModal').modal('hide');
        });
    </script>
    
    <script>
    // Validación en el submit del formulario
    document.getElementById('addressForm').addEventListener('submit', function(event) {
        // Verifica que los campos requeridos no estén vacíos
        let isValid = this.checkValidity();
        
        if (!isValid) {
            event.preventDefault(); // Evita que el formulario se envíe si no es válido
            alert('Por favor, complete todos los campos requeridos.');
        }
    }); 
   </script>
     
      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="js/jasny-bootstrap.min.js"></script>
    
    </body>
  </html>
  
   