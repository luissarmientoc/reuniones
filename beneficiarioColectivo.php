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
  $title="UNP | Beneficiarios Colectivo";  
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
  
  
    <script>
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
  
  <?php  
    include("navbar.php");
    // Crear una nueva instancia de conexi贸n PDO
    $pdo = new PDO($dsn);
    
    $s_LA    = $_GET['LA'];
    $linDeco = base64_decode($s_LA);
    
    echo $linDeco;
    echo '<br>';
   
    //PARTE LA LINEA
    $partir      = explode ("/", $linDeco);   
    $s_registro                 = $partir[0];
    $no_documento_ben_colectivo = $partir[1];
    $s_ot                       = $partir[2];
    $tipAccion                  = $partir[3];
    
    echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
    echo "registro.." . $s_registro;
    echo '<br>';
    echo "s_ot.." . $s_ot;
    echo '<br>';
    echo "dto.." . $no_documento_ben_colectivo;
    echo '<br>';
    
    if ( $no_documento_ben_colectivo != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "MODIFICAR BENEFICIARIO DEL COLECTIVO";
      $s_existe = 1;
      $boton  = "Actualizar";
      
      $sql = "select * from graerr_formulario_b where registro=$s_registro";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $registro = $row['registro'];
      $ot = $row['ot'];
      $tipo_documento_ben_colectivo = $row['tipo_documento_ben_colectivo'];
      $no_documento_ben_colectivo   = $row['no_documento_ben_colectivo'];
      $nombres_bene_colectivo       = $row['nombres_ben_colectivo'];
      $apellidos_ben_colectivo      = $row['apellidos_ben_colectivo'];
      $seudonimo_ben_colectivo     = $row['seudonimo_ben_colectivo'];
      $direccion_ben_colectivo      = $row['direccion_ben_colectivo'];
      $departamento                 = $row['departamento_ben_colectivo'];
      $municipio                    = $row['municipio_ben_colectivo'];
    }
     else
    {
      $titulo = "NUEVO BENEFICIARIO DEL COLECTIVO";
      $s_existe = 0;
      $boton="Grabar";
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
      $registro                     = $_POST['registro'];
      $ot                           = $_POST['ot'];
      $tipo_documento_ben_colectivo = $_POST['tipo_documento_ben_colectivo'];
      $no_documento_ben_colectivo   = $_POST['no_documento_ben_colectivo'];
      $nombres_bene_colectivo       = $_POST['nombres_ben_colectivo'];
      $apellidos_ben_colectivo      = $_POST['apellidos_ben_colectivo'];
      $seudonimo_ben_colectivo     = $_POST['seudonimo_ben_colectivo'];
      $direccion_ben_colectivo      = $_POST['direccion_ben_colectivo'];
      $departamento                 = $_POST['departamento'];
      $municipio                    = $_POST['municipio'];
      
      
      
      echo "1..". $s_registro;              
      echo '<br>';
      echo "2..". $registro;   
      echo '<br>';
      echo "3..". $ot;       
      echo '<br>';
      echo "4..". $tipo_documento_ben_colectivo; 
      echo '<br>';
      echo "5..". $no_documento_ben_colectivo;   
      echo '<br>';
      echo "6..". $nombres_bene_colectivo;      
      echo '<br>';
      echo "7..". $apellidos_ben_colectivo;     
      echo '<br>';
      echo "8..". $seudonimo_ben_colectivo;  
      echo '<br>';
      echo "10..". $departamento;   
      echo '<br>';
      echo "11..". $municipio;      
      echo '<br>';
      
      //MODIFICA
      if ($s_existe == "1")  
      {
        try {
            // Conectar a la base de datos
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparar la consulta SQL para actualizar
            $stmt = $pdo->prepare('
            UPDATE graerr_colectivo
            SET registro = ?, ot = ?, tipo_documento_ben_colectivo = ?,
                no_documento_ben_colectivo = ?, nombres_bene_colectivo = ?, apellidos_ben_colectivo = ?,
                seudonimo_beno_colectivo = ?, direccion_ben_colectivo = ?, departamento_ben_colectivo = ?,
                municipio_ben_colectivo = ?
                WHERE registro = ? and  no_documento_ben_colectivo = ? 
             ');
            
              $stmt->execute([
                     $registro, $ot, $tipo_documento_ben_colectivo,
                     $no_documento_ben_colectivo, $nombres_bene_colectivo, $apellidos_ben_colectivo,
                     $seudonimo_beno_colectivo,  $direccion_ben_colectivo, $departamento, $municipio,
                     $registro, $no_documento_ben_colectivo  // La llave del registro que se actualiza
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
         try {
               $stmt = $pdo->prepare('INSERT INTO graerr_colectivo (
                       registro, ot,  tipo_documento_ben_colectivo, no_documento_ben_colectivo , 
                       nombres_bene_colectivo, apellidos_ben_colectivo, seudonimo_beno_colectivo, 
                       direccion_ben_colectivo, departamento_ben_colectivo
                      ) VALUES (?, ?, ?, ?,
                                ?, ?, ?
                                ?, ?');     
                                
                       $stmt->execute([
                            $registro, $ot, $tipo_documento_ben_colectivo, $no_documento_ben_colectivo,
                            $nombres_bene_colectivo, $apellidos_ben_colectivo, $seudonimo_beno_colectivo,  
                            $direccion_ben_colectivo, $departamento, $municipio
                      ]);              
                   
                      $mensaje=" <b>Atención!</b> Grabación exitosa ¡";        
                    //echo "Datos insertados correctamente.";  
             
                 //echo "Datos insertados correctamente.";
                } catch (PDOException $e) {
            echo "Error al insertar los datos: " . $e->getMessage();
        }
    }//existe=0    
      
    }//grabar
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
      if ($line['id']==$tipo_documento_ben_colectivo)
      {
        $combo_tipo_documento .=" <option value='".$line['id']."' selected>".$line['tipo_documento']." </option>"; 
      }
      $combo_tipo_documento .=" <option value='".$line['id']."'>".$line['tipo_documento']."</option>"; 
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
                                 <p style="color:grey; font-size:14px; font-family:snas-serif:">Fecha de 煤ltimo ingreso: </p>
                             </div>
                          </div>
                    <!-- </nav>  ---->
                  <!--- FIN MENU CERRAR ---->
                  <br>
                  <!--- BARRA DE TITULO ---->
                  <div class="fondo"> 
                      <div class="row">
                       <div class="col-sm-6" ALIGN="left">
                          <h3> <i class='fas fa-building' style='color:#2f79b9'></i> BENEFICIARIO DEL COLECTIVO </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <?php
                          $lv   = $s_registro . "/MOD1234567890qwertyuiopasdfghjkl";
					      $lVDX = base64_encode($lv);
					     ?> 
                         <a href="graerrFormulario1.php?LA=<?=$lVDX?>" class='btn btn-default pull-right btn-md' title='Regresar' ><<i class="fas fa-reply"></i> Regresar</a> 
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
            <div class="container-fluid">
              <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"
	            <div class="row" style="margin:5px;">
	              
                <div class="row" style="margin:5px;">
	                <div class="col-sm-6" align="left">
                        <label style="font-size:12px;"  for="tipo_documento">TIPO DE DOCUMENTO DEL BENEFICIARIO DEL COLECTIVO</label>
                        <!--<input type="text" class="form-control" id="tipo_documento" name="tipo_documento"  value="<?=$tipo_documento_ben_colectivo?>" required>-->
                        <select <?=$active?> required class="form-control" name="tipo_documento_ben_colectivo">
                            <?php echo $combo_tipo_documento; ?>
                        </select> 
                    </div>  
                                
                    <div class="col-sm-6" align="left">
                        <label style="font-size:12px;"  for="no_documento">No DE DOCUMENTO DEL BENEFICIARIO DEL COLECTIVO</label>
                        <input type="number" class="form-control" id="no_documento_ben_colectivo" name="no_documento_ben"  value="<?=$no_documento_ben_colectivo?>" required>
                    </div>
                    
                    <div class="col-sm-4" align="left">
                        
                    </div>
                </div> <!--row-->
                
                
                <div class="row" style="margin:5px;">
	                <div class="col-sm-4" align="left">
                        <label style="font-size:12px;" for="nombres_apellidos_peticionario">NOMBRES DEL BENEFICIARIO DEL COLECTIVO</label>
                        <input  style="text-transform:uppercase;" type="text" class="form-control" id="nombres_ben_colectivo" name="nombres_ben_colectivo"  value="<?=$nombres_ben_colectivo?>" required>
                    </div>
                                
                    <div class="col-sm-4" align="left">
                        <label style="font-size:12px;" for="nombres_apellidos_peticionario">APELLIDOS DEL DEL BENEFICIARIO DEL COLECTIVO</label>
                        <input  style="text-transform:uppercase;" type="text" class="form-control" id="apellidos_ben_colectivo" name="apellidos_ben_colectivo"  value="<?=$apellidos_ben_colectivo?>" required>
                    </div>
                    
                    <div class="col-sm-4" align="left">
                        <label style="font-size:12px;" for="seudonimo">SEUDONIMO</label>
                        <input  style="text-transform:uppercase;" type="text" class="form-control" id="seudonimo_ben_colectivo" name="seudonimo_ben_colectivo"  value="<?=$seudonimo_ben_colectivo?>">
                    </div>
                </div> <!--row-->
                
                <div class="row" style="margin:5px;">
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
                </div> <!--row-->    
                
                <!--
                 <div class="row" style="margin:5px;">
                          <div class="col-sm-6" align="left">  
                              <label for="direccion">DIRECCION</label>
                              <input style="text-transform:uppercase;"  type="text" class="form-control" id="direccion" name="direccion"  value="<?=$direccion?>" required>
                          </div>
                       
                          <div class="col-sm-6" align="left">
                              <label for="corregimiento_vereda">CORREGIMIENTO O VEREDA</label>
                              <input  style="text-transform:uppercase;" type="text" class="form-control" id="corregimiento_vereda" name="corregimiento_vereda" value="<?=$corregimiento_vereda?>" required>
                          </div>
                 </div>  row-->    
                
                 <div class="modal-footer"> 
                    <div class="col-sm-11" align="center">  					  			 
                      <button type="submit" name='grabar' class="btn btn-md btn-success btn-lg"><i class="glyphicon glyphicon-refresh"></i> <?=$boton?> </button>
                    </div>	 
                 </div>
         
                 <input style="visibility:hidden" name="registro" id="registro" value="<?=$s_registro?>"/>
                 <input style="visibility:hidden" name="ot" id="ot" value="<?=$s_ot?>"/>
                 <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                 <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
              </form>    
            </div>     
             <!--- complemento -->
              <?php
              include("complemento.html");
            ?>
         <hr>
   <?php
    // include("footer.php");
   ?>
     <script type="text/javascript" src="buscarCiudad.js"></script>
  </body>
</html>            
            