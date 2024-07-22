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
  $title="UNP | Participante";  
  $nombreUsuario = $_SESSION['user_firstname'] ." " .$_SESSION['user_lastname']; 
  
  include("ciudades.php");
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
    $partir                   = explode ("/", $linDeco);   
    $s_numeroIdParticipante   = $partir[0];
    $tipAccion                = $partir[1];
    
    if ( $s_numeroIdParticipante != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo   = "MODIFICAR PARTICIPANTE";
      $s_existe = 1;
      $boton    = "Actualizar";
      
      $sql = "select * from reu_participante where numeroidparticipante=$s_numeroIdParticipante";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      //echo "Nombre: {$row['des_categoriareunion']}<br />";
      
      $s_idGrupoInterno       = $row['idgrupointerno'];
      $s_tipoDocumento        = $row['tipodocumento'];
      $s_numeroIdParticipante = $row['numeroidparticipante'];
      $s_nombresParticipante  = $row['nombresparticipante'];
      $s_celularParticipante  = $row['celularparticipante'];
      $s_correoParticipante   = $row['correoparticipante'];
      $s_departamento         = $row['departamento'];
      $s_ciudad               = $row['ciudad'];
      $s_codCiudad            = $row['ciudad'];
      $s_entidad              = $row['entidad'];
      $s_dependencia          = $row['dependencia'];
      $s_cargo                = $row['cargo'];
      
      $s_nombresParticipante = strtoupper($s_nombresParticipante);
      $s_cargo = strtoupper($s_cargo);
      $s_correoParticipante = strtolower($s_correoParticipante);
      /*
      //TRAE NOMBRES DE CIUDAD Y DEPARTAMENTO
      $sqlDepto="select nomDepto from sl_municipios where codDepto=$s_departamento group by nomDepto ";
      $queryDepto = mysqli_query($con, $sqlDepto);  
      $rowDepto=mysqli_fetch_array($queryDepto);
      $s_nomDepto = $rowDepto['nomDepto'];
    
      //TRAE NOMBRES DE CIUDAD Y DEPARTAMENTO
      $sqlMpio="select nomMunicipio from sl_municipios where codDepto=$s_departamento and codMunicipio=$s_ciudad";
      $queryMpio = mysqli_query($con, $sqlMpio);  
      $rowMpio=mysqli_fetch_array($queryMpio);
      $s_nomCiudad = $rowMpio['nomMunicipio'];
      */

    }  
    else
    {
      $titulo = "NUEVO PARTICIPANTE";
      $s_existe = 0;
      $boton="Grabar";
    }  
    
   if(isset($_POST['grabar']))
   {   
      $s_tipoDocumento        = $_POST['tipoDocumento'];
      $s_numeroIdParticipante = $_POST['numeroIdParticipante'];
      $s_nombresParticipante  = $_POST['nombresParticipante'];
      $s_celularParticipante  = $_POST['celularParticipante'];
      $s_correoParticipante   = $_POST['correoParticipante'];
      $s_departamento         = $_POST['departamento'];
      $s_ciudad               = $_POST['id_ciudad'];
      $s_codCiudad            = $_POST['codCiudad']; 
      //$s_ciudad             = $_POST['ciudad'];
      $s_entidad              = $_POST['entidad'];
      $s_dependencia          = $_POST['dependencia'];
      $s_cargo                = $_POST['cargo'];
     
     
      $s_nombresParticipante = strtoupper($s_nombresParticipante);
      if($s_ciudad=="")
     {
       $s_ciudad=$s_codCiudad;
     }
      
      //TRAE NOMBRES DE CIUDAD Y DEPARTAMENTO
      $sqlDepto="select nomDepto from sl_municipios where codDepto=$s_departamento group by nomDepto ";
      $queryDepto = mysqli_query($con, $sqlDepto);  
      $rowDepto=mysqli_fetch_array($queryDepto);
      $s_nomDepto = $rowDepto['nomDepto'];
    
      //TRAE NOMBRES DE CIUDAD Y DEPARTAMENTO
      $sqlMpio="select nomMunicipio from sl_municipios where codDepto=$s_departamento and codMunicipio=$s_ciudad";
      $queryMpio = mysqli_query($con, $sqlMpio);  
      $rowMpio=mysqli_fetch_array($queryMpio);
      $s_nomCiudad = $rowMpio['nomMunicipio'];
   
      $s_existe         = $_POST['existe'];
      $s_yaGrabo        = $_POST['yaGrabo'];
    
      date_default_timezone_set('America/Bogota');
      //$s_fecha  = date("Y-m-d",time());
      //$s_fecha  = date("Y/m/d H:i:s");
      $date_added=date("Y-m-d H:i:s");
     
      /////////////////////////////////////////////  
      ////// VERIFICA A EXISTENCIA DE LA marca
      /////////////////////////////////////////////
      //$sql   = "SELECT count(*) AS cuantos FROM marcas WHERE id_marca = $s_id_marca";
      //$query = mysqli_query($con, $sql);  
      //$row   = mysqli_fetch_array($query);
      
      ///MODIFICA
      if ($s_existe == "1")  
      {
        $sql= "UPDATE reu_participante SET tipodocumento = :tipodocumento, nombresparticipante = :nombresparticipante, 
                                           celularparticipante = :celularparticipante, correoparticipante = :correoparticipante, 
                                           departamento = :departamento, ciudad = :ciudad, entidad = :entidad, dependencia = :dependencia, 
                                           cargo = :cargo WHERE numeroidparticipante = :numeroidparticipante";
        $stmt = $pdo->prepare($sql);
    
        // Vincular parámetros
        $stmt->bindParam(':tipodocumento', $s_tipoDocumento, PDO::PARAM_INT);
        $stmt->bindParam(':nombresparticipante', $s_nombresParticipante, PDO::PARAM_STR);
        $stmt->bindParam(':celularparticipante', $s_celularParticipante, PDO::PARAM_STR);
        $stmt->bindParam(':correoparticipante', $s_correoParticipante, PDO::PARAM_STR);
        $stmt->bindParam(':departamento', $s_departamento, PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $s_ciudad, PDO::PARAM_STR);
        $stmt->bindParam(':entidad', $s_entidad, PDO::PARAM_STR);
        $stmt->bindParam(':dependencia', $s_dependencia, PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $s_cargo, PDO::PARAM_STR);
        $stmt->bindParam(':numeroidparticipante', $s_numeroIdParticipante, PDO::PARAM_INT);;
        
        // Ejecutar la consulta
         $stmt->execute();
      }  
      
      ///ADICIONA
      if ($s_existe == "0")
      {
        $stmt = $pdo->prepare('INSERT INTO reu_participante (tipodocumento, numeroidparticipante, nombresparticipante, celularparticipante, 
                           correoparticipante, departamento, ciudad, entidad, dependencia, cargo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$s_tipoDocumento, $s_numeroIdParticipante, $s_nombresParticipante, $s_celularParticipante, $s_correoParticipante, 
              $s_departamento, $s_ciudad, $s_entidad, $s_dependencia, $s_cargo]);
        
        $mensaje=" <b>Atención!</b> Grabación exitosa ¡";
        
        $s_existe ="1";
      }   
       
      $s_tocoBoton = "S";  
          
   }//grabar
   
   
   //============================= CONSULTA EL tipo de documento
  //============================================================================ 
   
  $stmt = $pdo->query('select * from tipo_documento order by iddocumento');
  $i=0;
  
  while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboTipoDoc .=" <option value=''>".'- Seleccione el tipo de documento -'."</option>";
      }
      if ($line['iddocumento']==$s_tipoDocumento)
      {
        $comboTipoDoc .=" <option value='".$line['iddocumento']."' selected>".$line['nombre']." </option>"; 
      }
      $comboTipoDoc .=" <option value='".$line['iddocumento']."'>".$line['nombre']."</option>"; 
      $i++; 
    }
  
    //============================= CONSULTA LA ENTIDAD
    //============================================================================ 
    $stmt = $pdo->query('SELECT * FROM reu_entidades order by nombreentidad');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboEntidad .=" <option value=''>".'- Seleccione la entidad -'."</option>";
      }
      if ($line['identidad']==$s_entidad)
      {
        $comboEntidad .=" <option value='".$line['identidad']."' selected>".$line['nombreentidad']." </option>"; 
      }
      $comboEntidad .=" <option value='".$line['identidad']."'>".$line['nombreentidad']."</option>"; 
      $i++; 
    }
    
    //============================= CONSULTA LA DEPENDENCIA
    //============================================================================ 
    $stmt = $pdo->query('SELECT * FROM reu_dependencias order by nombredependencia');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboDependencia .=" <option value=''>".'- Seleccione la dependencia -'."</option>";
      }
      if ($line['iddependencia']==$s_dependencia)
      {
        $comboDependencia .=" <option value='".$line['iddependencia']."' selected>".$line['nombredependencia']." </option>"; 
      }
      $comboDependencia .=" <option value='".$line['iddependencia']."'>".$line['nombredependencia']."</option>"; 
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
      if ($line['coddepto']==$s_entidad)
      {
        $comboDepto .=" <option value='".$line['coddepto']."' selected>".$line['nomdepto']." </option>"; 
      }
      $comboDepto .=" <option value='".$line['coddepto']."'>".$line['nomdepto']."</option>"; 
      $i++; 
    }
    
    //TRAE NOMBRES DE CIUDAD Y DEPARTAMENTO
    if ($s_ciudad>0)
    {
      $sql = "select codmunicipio, nommunicipio from reu_municipios where coddepto='$s_departamento' and codmunicipio='$s_ciudad'";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
      $s_nomCiudad = $row['nommunicipio'];
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
                          <h3> <i class='fas fa-user-friends' style='color:#2f79b9'></i> PARTICIPANTE </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <a href="participante0.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
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
                  <!--<div class="row"> --->
                    <div class=" col-md-12 col-lg-12 " > 
                        <!--<table class="table table-condensed">
                         <tbody> -->
                             <div class="row" style="padding:5px;">
                                <div class='col-md-6' align="left"><b> Tipo de identificación: </b></div>
                                <div class='col-md-6' align="left"><b> Número de identificación: </b></div>
                              </div> 
                             
                              <div class="row">
                                  <div class='col-md-6' align="left"> 
                                      <select <?=$active?> required class="form-control" name="tipoDocumento">
                                          <?php echo $comboTipoDoc; ?>
                                       </select> 
                                  </div>
                                  <div class='col-md-6' align="left"> 
                                      <input type="number" class="form-control" id="numeroIdParticipante" name="numeroIdParticipante" value="<?=$s_numeroIdParticipante?>" placeholder="Número de documento" required>			                         
                                  </div>
                              </div>
                             
                              <div class="row" style="padding:5px;">
                                <div class='col-md-12' align="left" colspan="2"><b> Nombre del participante: </b></div>
                              </div>    
                              
                              <div class="row">
                                <div class='col-md-12' align="left" colspan="2">    
                                    <input type="text" class="form-control" id="nombresParticipante" name="nombresParticipante" value="<?=$s_nombresParticipante?>" placeholder="Nombres del participante" required style="text-transform:uppercase;">			                         
                                </div>        
                              </div>    
                             
                              <div class="row" style="padding:5px;">    
                                <div class='col-md-6' align="left"><b> Celular participante: </b></div>
                                <div class='col-md-6' align="left"><b> Correo participante: </b></div>
                              </div>
                              
                              <div class="row" style="padding:5px;">
                                <div class='col-md-6' align="left"> 
                                      <input type="number" class="form-control" id="celularParticipante" name="celularParticipante" value="<?=$s_celularParticipante?>" placeholder="Número de celular" required>			                         
                                </div>
                                <div class='col-md-6' align="left"> 
                                      <input type="mail" class="form-control" id="correoParticipante" name="correoParticipante" value="<?=$s_correoParticipante?> " placeholder="Correo" required style="text-transform:lowercase;">			                         
                                </div>
                              </div>
                              
                              <div class="row" style="padding:5px;">
                                <div class='col-md-4' align="left"><b> Departamento: </b></div>
                                <div class='col-md-4' align="left"><b> Ciudad: </b></div>
                                <div class='col-md-4' align="left"><b> Ciudad: </b></div>
                               </div>    
                               
                               <div class="row" style="padding:5px;">
                                   <div class='col-md-4' align="left">
                                      <select required class="form-control" name="departamento" id="departamento" onchange="loadCiudad(this.value)">
                                        <?php echo $comboDepto; ?>
                                      </select>
                                    </div>
                                    <div class='col-md-4' align="left">
                                      <div id="myDiv"> </div>
                                    </div>
                                    <div class='col-md-4'  colspan="2" align="left">
                                      <input  style=display:none; class="form-control" type="text" readonly value="<?=$s_codCiudad?>" name="codCiudad" id="codCiudad">
                                      <input type="text" class="form-control" id="nombre_ciudad" name="nombre_ciudad" value="<?=$s_nomCiudad?> " placeholder="Nombre del municipio" readonly><br>  
                                    </div>
                               </div>
                               
                               <div class="row" style="padding:5px;">
                                 <div class='col-md-6' align="left"><b> Entidad: </b></div>
                                 <div class='col-md-6' align="left"><b> Dependencia: </b></div>
                               </div>
                               
                               <div class="row" style="padding:5px;">
                                 <div class='col-md-6' align="left"> 
                                      <select required class="form-control" name="entidad" id="entidad">
                                        <?php echo $comboEntidad; ?>
                                      </select>
                                 </div>
                                 <div class='col-md-6' align="left">
                                   <select required class="form-control" name="dependencia" id="dependencia">
                                        <?php echo $comboDependencia; ?>
                                      </select>
                                 </div>
                               </div>
                               
                               <div class="row" style="padding:5px;">
                                <div class='col-md-12' align="left" colspan="2"><b> Cargo: </b></div>
                              </div>    
                              
                              <div class="row">
                                <div class='col-md-12' align="left" colspan="2">    
                                    <input type="text" class="form-control" id="cargo" name="cargo" value="<?=$s_cargo?>" placeholder="Cargo del participante" required style="text-transform:uppercase;">			                         
                                </div>        
                              </div>   
                             
                           
                        <!-- </tbody>
                        </table> -->			
                     </div>        	      
                  <!-- </div> row-->        	       
                </div> <!-- panel body -->	 
              
               <div class="modal-footer"> 
                <div class="col-sm-11" align="right">  					  			 
                  <button type="submit" name='grabar' class="btn btn-md btn-success"><i class="glyphicon glyphicon-refresh"></i> <?=$boton?> </button>
                </div>	 
              </div>
         
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
  
   