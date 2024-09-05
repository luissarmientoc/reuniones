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
             
          function concatenarDir() {
                
                    // const addressType = document.getElementById('addressType').value;
                   // const ruralType = document.getElementById('ruralType') ? document.getElementById('ruralType').value : '';
                   // const urbanoType = document.getElementById('urbanoType') ? document.getElementById('urbanoType').value : '';
                    const tipo_via = document.getElementById('tipo_via') ? document.getElementById('tipo_via').value : '';
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
        $titulo = "MODIFICAR ENTIDAD";
        $s_existe = 1;
        $boton  = "Actualizar";
        
        $sql = "select * from mt_anexotecnico where registro=$s_registro";
        $stmt = $pdo->query($sql);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
          
            $registro               = $row['registro'];
            $conteo_acta            = $row['conteo_acta']; 
            $conteo_porsesion       = $row['conteo_porsesion'];
            $tipo_estudio_riesgo    = $row['tipo_estudio']; 
            $ot                     = $row['ot'];
            $tipo_documento         = $row['tipo_documento'];
            $no_documento           = $row['no_documento']; 
            $nombres_peticionario   = $row['nombres_peticionario']; 
            $apellidos_peticionario = $row['apellidos_peticionario']; 
            $correo_electronico     = $row['correo_electronico'];
            $no_de_contacto          = $row['no_de_contacto'];
            
            $analista_riesgo        = $row['analista_riesgo']; 
            $recomendacion_riesgo_premesa = $row['recomendacion_riesgo_premesa']; 
            $recomendacion_medidas_premesa = $row['recomendacion_medidas_premesa']; 
            $consenso               = $row['consenso']; 
            $detalle_consenso       = $row['detalle_consenso'];
            
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
            
            //trae los datos e la direccion
             $sql1 = "select * from graerr_direccion where registro=$registro";
             $stmt1 = $pdo->query($sql1);
             $row1  = $stmt1->fetch(PDO::FETCH_ASSOC);
             
             $addressType                  = $row1['addresstype'];                     
             $ruralType                    = $row1['ruraltype'];
             $urbanoType                   = $row1['urbanotype'];
             $tipo_via                     = $row1['tipo_via'];
             $cuadrante                    = $row1['cuadrante'];
             $via_generadora               = $row1['via_generadora'];
             $letra_via_generadora         = $row1['letra_via_generadora']; 
             $sufijo                       = $row1['sufijo'];
             $letra_sufijo                 = $row1['letra_sufijo'];
             $numero_placa                 = $row1['numero_placa'];
             $cuadrante_numero_placa       = $row1['cuadrante_numero_placa'];
             $complemento                  = $row1['complemento'];
             
             
             $sql   = "SELECT descripcion from graerr_tipo_estudio_riesgo where id = $tipo_estudio_riesgo";
	         $stmt  = $pdo->query($sql);
	         $row   = $stmt->fetch(PDO::FETCH_ASSOC);
             $tipo_estudio_riesgo = $row['descripcion'];
             
              if($consenso=="Si"){
                $conS="selected"; 
                $conN=""; 
             }  
             else
             {
                $conS=""; 
                $conN="selected";  
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
      }
      
      if(isset($_POST['grabar']))
      { 
             $s_existe         = $_POST['existe'];
             $s_yaGrabo        = $_POST['yaGrabo'];
             date_default_timezone_set('America/Bogota');
             //$s_fecha  = date("Y-m-d",time());
             //$s_fecha  = date("Y/m/d H:i:s");
             $date_added=date("Y-m-d H:i:s");
      
             $conteo_acta                   = $_POST['conteo_acta'];
             $conteo_porsesion              = $_POST['conteo_porsesion'];
             $tipo_estudio_riesgo           = $_POST['tipo_estudio:riesgo'];
             $tipo_ruta                     = $_POST['tipo_ruta'];
             $ot                            = $_POST['ot'];
             $fecha_asignado_ot             = $_POST['fecha_asignado_ot'];
             $tipo_documento                = $_POST['tipo_documento'];
             $no_documento                  = $_POST['no_documento'];
             $nombres_peticionario          = $_POST['nombres_peticionario'];
             $apellidos_peticionario        = $_POST['apellidos_peticionario'];
             $correo_electronico            = $_POST['correo_electronico'];
             $no_de_contacto                = $_POST['no_de_contacto'];
             
             
             $analista_riesgo               = $_POST['analista_riesgo'];
             $recomendacion_medidas_premesa = $_POST['recomendacion_medidas_premesa'];
             $recomendacion_riesgo_premesa  = $_POST['recomendacion_riesgo_premesa'];
             $consenso                      = $_POST['consenso'];
             $detalle_consenso              = $_POST['detalle_consenso'];
             $orden                         = $_POST['orden'];
             $temporalidad                  = $_POST['temporalidad'];
             $obs_temporalidad              = $_POST['obs_temporalidad'];
             
             $departamento                  = $_POST['departamento'];
             $municipio                     = $_POST['municipio'];
             $addressType                   = $_POST['addressType'];
             $ruralType                     = $_POST['ruralType'];
             $eltipodireccion               = $_POST['eltipodireccion'];
             $nomtipodireccion              = $_POST['nomtipodireccion'];
             $tipo_via                      = $_POST['tipo_via'];
             $cuadrante                     = $_POST['cuadrante'];
             $via_generadora                = $_POST['via_generadora'];
             $letra_via_generadora          = $_POST['letra_via_generadora'];
             $sufijo                        = $_POST['sufijo'];
             $letra_sufijo                  = $_POST['letra_sufijo'];
             $numero_placa                  = $_POST['numero_placa'];
             $cuadrante_numero_placa        = $_POST['cuadrante_numero_placa'];
             $corregimiento_vereda          = $_POST['corregimiento_vereda'];
             $direccion                     = $_POST['direccion'];
             
             $subpoblacion                  = $_POST['subpoblacion'];
             $factor_diferencial            = $_POST['factor_diferencial'];
             $motivacion                    = $_POST['motivacion'];
             $obsadicionales_graerr         = $_POST['obsadicionales_graerr'];
             $observaciones_smt             = $_POST['observaciones_smt'];
             
             $estado=2;
             $fecha_estado = date("Y-m-d H:i:s");
             
              $sql   = "SELECT descripcion from graerr_tipo_estudio_riesgo where id = $tipo_estudio_riesgo";
	         $stmt  = $pdo->query($sql);
	         $row   = $stmt->fetch(PDO::FETCH_ASSOC);
             $tipo_estudio_riesgo = $row['descripcion'];
             
             if ($sufijo==""){
                $sufN="selected";
                $sufS="";
             }
             else
             {
                $sufS="selected"; 
                $sufN="";
             }
             
             if($consenso=="Si"){
                $conS="selected"; 
                $conN=""; 
             }  
             else
             {
                $conS=""; 
                $conN="selected";  
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
             
             echo '<br>';
             echo "1.." . $conteo_acta;
             echo '<br>';
             echo "2.." . $conteo_porsesion;
             echo '<br>';
             echo "3.." . $tipo_estudio_riesgo;
             echo '<br>';
             echo "4.." . $tipo_ruta;
             echo '<br>';
             echo "5.." . $ot;
             echo '<br>';
             echo "6.." . $fecha_asignado_ot;
             echo '<br>';
             echo "7.." . $tipo_documento;
             echo '<br>';
             echo "8.." . $no_documento;
             echo '<br>';
             echo "9.." . $nombres_peticionario;
             echo '<br>';
             echo "10.." . $apellidos_peticionario;
             echo '<br>';
             echo "11.." . $analista_riesgo;
             echo '<br>';
             echo "12.." . $recomendacion_medidas_premesa;
             echo '<br>';
             echo "13.." . $recomendacion_riesgo_premesa;
             echo '<br>';
             echo "14.." . $consenso;
             echo '<br>';
             echo "15.." . $detalle_consenso;
             echo '<br>';
             echo "16.." . $orden;
             echo '<br>';
             echo "17.." . $temporalidad;
             echo '<br>';
             echo "18.." . $obs_temporalidad;
             echo '<br>';
             
             echo "19.." . $departamento;
             echo '<br>';
             echo "20.." . $municipio;
             echo '<br>';
             echo "21.." . $addressType;
             echo '<br>';
             echo "22.." . $ruralType;
             echo '<br>';
             echo "23.." . $eltipodireccion;
             echo '<br>';
             echo "24.." . $nomtipodireccion;
             echo '<br>';
             echo "25.." . $tipo_via;
             echo '<br>';
             echo "26.." . $cuadrante;
             echo '<br>';
             echo "27.." . $letra_via_generadora;
             echo '<br>';
             echo "28.." . $sufijo;
             echo '<br>';
             echo "29.." . $letra_sufijo;
             echo '<br>';
             echo "30.." . $numero_placa;
             echo '<br>';
             echo "31.." . $cuadrante_numero_placa;
             echo '<br>';
             echo "32.." . $corregimiento_vereda;
             echo '<br>';
             echo "33.." . $direccion;
             echo '<br>';
             
             echo "34.." . $subpoblacion;
             echo '<br>';
             echo "35.." . $factor_diferencial;
             echo '<br>';
             echo "36.." . $motivacion;
             echo '<br>';
             echo "37.." . $obsadicionales_graerr;
             echo '<br>';
             echo "38.." . $observaciones_smt;
             echo '<br>';
             
      }//GRABAR
      
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
    
    //============================= ANO
    //============================================================================ 
    $stmt = $pdo->query('SELECT ano FROM graerr_bas_ano order by ano');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $combo_ano .=" <option value=''>".'- Seleccione el número de meses -'."</option>";
      }
      if ($line['ano']==$temporalidad)
      {
        $combo_ano .=" <option value='".$line['ano']."' selected>".$line['ano']." </option>"; 
      }
      
       $combo_ano .=" <option value='".$line['ano']."'>".$line['ano']."</ano>"; 
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
                         <a href="graerrAmtsp.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
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
                            <div class="col-sm-6" align="left">
                               <label for="conteo_acta">Conteo por acta:</label>
                               <input type="text" class="form-control" id="conteo_acta" name="conteo_acta"  value="<?=$conteo_acta?>" required>
                           </div>
                           <div class="col-sm-6" align="left">
                               <label for="conteo_porsesion">Conteo por sesión:</label>
                               <input type="text" class="form-control" id="conteo_porsesion" name="conteo_porsesion"  value="<?=$conteo_porsesion?>"  >
                           </div>
                            
                        </div> <!-- row -->    
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-6" align="left">
                               <label for="tipo_estudio_riesgo">TIPO ESTUDIO DE RIESGO</label>
                               <select <?=$active?> required class="form-control" name="tipo_estudio_riesgo">
                                 <?php echo $combo_tipo_estudio_riesgo; ?>
                               </select>
                            </div>
                           
                            <div class="col-sm-6" align="left">
                              <label for="tipo_ruta">TIPO DE RUTA</label>
                               <select <?=$active?> required class="form-control" id="tipo_ruta" name="tipo_ruta">
                                 <?php echo $combo_tipo_ruta; ?>
                               </select>
                           </div>
                        </div> <!-- row -->    
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-6" align="left">
                               <label for="$ot">OT:</label>
                               <input type="text" class="form-control" id="ot" name="ot"  value="<?=$ot?>" required  >
                            </div>
                           
                            <div class="col-sm-6" align="left">
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
                               <textarea  style="text-transform:uppercase;" class="form-control" id="recomendacion_riesgo_premesa" name="recomendacion_riesgo_premesa" rows="3"> <?=$recomendacion_riesgo_premesa?></textarea>
                            </div>
                        </div> <!-- row -->        
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-6" align="left">
                               <label for="consenso">Consenso:</label>
                                    <select class="form-control" id="consenso" name="consenso">
                                          <option value="">Seleccione Consenso</option>
                                          <option value="Si" <?=$conS?> >Si</option>
                                          <option value="No" <?=$conN?> >No</option>
                                    </select>   
                            </div>
                        </div> <!-- row -->
                        
                        <div class="row" style="margin-top:5px;">    
                            <div class="col-sm-12" align="left">
                               <label for="detalle_consenso">Detalle del Consenso:</label><br>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="detalle_consenso" name="detalle_consenso" rows="3"> <?=$detalle_consenso?></textarea>
                            </div>
                        </div> <!-- row --> 
                        
                        <div class="row" style="margin-top:5px;">    
                            <div class="col-sm-6" align="left">
                               <label for="orden">Orden:</label> 
                               <input type="text" class="form-control" id="orden" name="orden"  value="<?=$orden?>" required >
                            </div>
                        </div> <!-- row -->    
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-6" align="left">
                               <label for="orden">Temporalidad:</label> 
                               <select class="form-control" id="temporalidad" name="temporalidad">
                                    <?php echo $combo_ano; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top:5px;">    
                            <div class="col-sm-12" align="left"> 
                               <label for="obs_temporalidad">Observaciones Temporalidad:</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="obs_temporalidad" name="obs_temporalidad" rows="3"> <?=$obs_temporalidad?></textarea>
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
                                   <label for="cuadrante_tipo_via">Cuadrante:</label> 
                                   <div class="form-group">
                                     <select <?=$active?>  class="form-control" id="cuadrante" name="cuadrante" onchange="concatenarDir();">
                                         <?php echo $combo_cuadrante; ?>
                                      </select>
                                   </div> 
                            </div>
                       
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
                                      <input  style="text-transform:uppercase;" type="text" class="form-control" id="corregimiento_vereda" name="corregimiento_vereda" value="<?=$corregimiento_vereda?>" required oninput="concatenarDir();">
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
                       
                       
                       <div class="row" style="margin-top:5px;">                          
                          <div class="col-sm-6" align="left"> 
                              <label for="correo_electronico">CORREO ELECTRONICO</label>
                              <input style="text-transform:lowercase;" type="email" class="form-control" id="correo_electronico" name="correo_electronico"   value="<?=$correo_electronico?>"required>
                          </div> 
                          <div class="col-sm-6" align="left">
                              <label for="no_contacto">No DE CONTACTO</label>
                              <input min="0" type="number" class="form-control" id="no_de_contacto" name="no_de_contacto"  value="<?=$no_de_contacto?>" required>
                          </div>
                       </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-6" align="left">
                               <label for="subpoblacion">Poblacion:</label> 
                               <select <?=$active?> required class="form-control" name="subpoblacion" required>
                                 <?php echo $combo_subpoblacion; ?>
                              </select>
                            </div>
                            
                            <div class="col-sm-6" align="left">
                               <label for="factor_diferencial">Factor Diferencial:</label>
                               <select <?=$active?> required class="form-control" name="factor_diferencial">
                                  <?php echo $combo_factor_diferencial; ?>
                               </select>
                            </div>
                        </div> <!-- row -->       
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-12" align="left">
                               <label for="motivacion">Motivacion:</label> 
                               <textarea  style="text-transform:uppercase;" class="form-control" id="motivacion" name="motivacion" rows="3"> <?=$motivacion?></textarea>
                            </div>
                        </div> <!-- row -->        
                        
                        <div class="row" style="margin-top:5px;">    
                            <div class="col-sm-12" align="left">
                               <label for="motivacion">Observaciones Adicionales Graerr:</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="obsadicionales_graerr" name="obsadicionales_graerr" rows="3"> <?=$obsadicionales_graerr?></textarea>
                            </div>
                        </div> <!-- row -->     
                        
                        <div class="row" style="margin-top:5px;">
                            <div class="col-sm-12" align="left">
                               <label for="observaciones_smt">Observaciones Adicionales MTSP:</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="observaciones_smt" name="observaciones_smt" rows="3"> <?=$observaciones_smt?> </textarea>
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