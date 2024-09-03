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
  
  </head>
  
  <?php  
    include("navbar.php");
    // Crear una nueva instancia de conexi¨®n PDO
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
             $tipo_documento                = $row['tipo_documento'];
             $no_documento                  = $row['no_documento'];
             $analista_riesgo               = $row['analista_riesgo'];
             $recomendacion_riesgo_premesa  = $row['recomendacion_riesgo_premesa'];
             $recomendacion_medidas_premesa = $row['recomendacion_medidas_premesa'];
             $departamento                  = $row['departamento'];
             $municipio                     = $row['municipio'];
             $no_de_contacto                = $row['no_de_contacto'];
             $factor_diferencial            = $row['factor_diferencial'];
             $subpoblacion                  = $row['subpoblacion'];
             $direccion                     = $row['direccion'];
             
             // Decodifica campos
             //tipo_documento
             $sql1 = "select * from graerr_tipo_documento where id=$tipo_documento";
             $stmt1   = $pdo->query($sql1);
             $row1      = $stmt1->fetch(PDO::FETCH_ASSOC);
             $documento = $row1['tipo_documento'];
             
             echo '<br>';
             echo "documento.." . $documento;
             echo '<br>';
 
             $sql2 = "select nombre_analista from graerr_analista_riesgo where id=$analista_riesgo";
             $stmt2     = $pdo->query($sql2);
             $row2      = $stmt2->fetch(PDO::FETCH_ASSOC);
             $analista  = $row2['nombre_analista'];
             
             echo '<br>';
             echo "analista.." . $analista;
             echo '<br>';
             
             $sql3 = "select descripcion from graerr_recomendacion_premesa where id=$recomendacion_medidas_premesa";
             $stmt3     = $pdo->query($sql3);
             $row3      = $stmt3->fetch(PDO::FETCH_ASSOC);
             $rec_med_prem  = $row3['descripcion'];
             
             echo '<br>';
             echo "rec_med_prem.." . $rec_med_prem;
             echo '<br>';
             
             $sql4 = "select factor_diferencial from graerr_factor_diferencial where id=$factor_diferencial";
             $stmt4         = $pdo->query($sql4);
             $row4          = $stmt4->fetch(PDO::FETCH_ASSOC);
             $fact_dif      = $row4['factor_diferencial'];
              
             echo '<br>';
             echo "fact_dif.." . $fact_dif;
             echo '<br>';
             
             $sql5 = "select descripcion from graerr_poblacion where id=$subpoblacion";
             $stmt5         = $pdo->query($sql5);
             $row5          = $stmt5->fetch(PDO::FETCH_ASSOC);
             $subpob        = $row5['descripcion'];
              
             echo '<br>';
             echo "subpob.." . $subpob;
             echo '<br>';
              
            
             
             
    }
  ?>
        <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="js/jasny-bootstrap.min.js"></script>
    
    </body>
  </html>