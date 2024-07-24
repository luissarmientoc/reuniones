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
  $title="UNP | Reuniones";  
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
   function confirmar()
   {
    if(confirm('¿Estas seguro de eliminar el participante?'))
      return true;
    else
    return false;
   }
   
   function confirmarCompromiso()
   {
    if(confirm('¿Estas seguro de eliminar el compromiso?'))
      return true;
    else
    return false;
   }
  </script>
  
  <?php  
   include("navbar.php");
    // Crear una nueva instancia de conexión PDO
    $pdo = new PDO($dsn);
   
    $s_LA    = $_GET['LA'];
    $linDeco = base64_decode($s_LA);
   
    //PARTE LA LINEA
    $partir      = explode ("/", $linDeco);   
    
    $s_idReunion   = $partir[0];
    $tipAccion     = $partir[1];
    
    if(isset($_POST['compromiso']))
    {
        $s_idReunion    = $_POST['idReunion']; 
        $s_participante = $_POST['participante'];
        $s_compromiso   = $_POST['compromisoTxt'];
        $compromisoP    = $_POST['compromisoP'];
        $s_yaGrabo      = $_POST['yaGrabo'];
        $s_existe       = $_POST['existe']; 
        $s_fechaFinalCompromiso = $_POST['fechaFinalCompromiso']; 
       
        $partir  = explode ("-", $compromisoP);   
        $s_idReunion     = $partir[0];
        $s_participante  = $partir[1];
        
        date_default_timezone_set('America/Bogota');
        //$s_fecha  = date("Y-m-d",time());
        //$s_fecha  = date("Y/m/d H:i:s");
        $date_added=date("Y-m-d");
        
        $sql = "SELECT MAX(idcompromiso) AS maximo FROM reu_compromisos";
        $stmt = $pdo->query($sql);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $s_maximo = $row['maximo'];
        
        $s_idCompromiso     = $s_maximo+1;
        
        //estado ->1:Iniciado, 2:EnCurso, 3:Cumplido, 4:Incumplido 
        $s_estado = 1;
        // Inserción de datos
        $stmt = $pdo->prepare('INSERT INTO reu_compromisos (idreunion, numeroidparticipante, idcompromiso, fechainicialcompromiso, fechafinalcompromiso, compromisoadquirido, tareasrealizadas, estado) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$s_idReunion, $s_participante, $s_idCompromiso, $date_added, $s_fechaFinalCompromiso, $s_compromiso, '', $s_estado]);
        
    }
    
    if(isset($_POST['borrarCompromiso']))
    {
       $borrarComp  = $_POST['borrarCompromiso'];
       $partir  = explode ("-", $borrarComp);   
       $reu     = $partir[0];
       $par     = $partir[1];
       $comp    = $partir[2];
       
       $sql = "SELECT count(*) as ctsTareas from reu_tareas_realizadas where idreunion=$s_idReunion and numeroidparticipante=$par and idcompromiso=$comp";
       $stmt = $pdo->query($sql);
       $row  = $stmt->fetch(PDO::FETCH_ASSOC);
       $ctsTareas = $row['ctsTareas'];
       
       if ($ctsTareas==0)
       {
         // Consulta preparada con marcadores de posición
         $sql = "DELETE FROM reu_compromisos WHERE idreunion = :idReunion AND numeroidparticipante = :numeroIdParticipante AND idcompromiso = :idCompromiso";
        
         // Preparar la consulta
         $stmt = $pdo->prepare($sql);
        
         // Asignar valores a los marcadores de posición
         $stmt->bindParam(':idreunion', $idReunion, PDO::PARAM_INT);
         $stmt->bindParam(':numeroidparticipante', $numeroIdParticipante, PDO::PARAM_INT);
         $stmt->bindParam(':idcompromiso', $idCompromiso, PDO::PARAM_INT);

         // Ejecutar la consulta
         if ($stmt->execute()) {
             echo "Se eliminó el registro correctamente.";
         } else {
             echo "Error al intentar eliminar el registro.";
         }
       }
       else
       {
          echo '<script>alert("No se puede eliminar el compromiso \n El participante para este comprimiso ya tiene tareas realizadas...");</script>';
       
       }
       
       $s_idReunion           = $_POST['idReunion']; 
       $s_existe              = $_POST['existe'];
       $s_yaGrabo             = $_POST['yaGrabo'];
    }   
    
    if(isset($_POST['borrar']))
    {
     $borrar  = $_POST['borrar'];
     $partir  = explode ("-", $borrar);   
     $reu     = $partir[0];
     $par     = $partir[1];
     
     $s_existe=0;
     $sql = "select count(*) as existe from reu_compromisos where idreunion=$reu and numeroidparticipante=$par";
     echo "cuats .. " .$sql;
     $stmt = $pdo->query($sql);
     $row  = $stmt->fetch(PDO::FETCH_ASSOC);
     $s_existe     = $row1["existe"];
     
     if($s_existe==0)
     {
       // Consulta preparada con marcadores de posición
       $sql  = "DELETE FROM reu_reuniones_participante WHERE idreunion =:reu and numeroidparticipante =:par";
       echo '<br>';
       echo "borrar .." . $sql;
       echo '<br>';
       
       // Preparar la consulta
       $stmt = $pdo->prepare($sql);
        
       // Asignar valores a los marcadores de posición
       $stmt->bindParam(':idreunion', $idReunion, PDO::PARAM_INT);
       $stmt->bindParam(':numeroidparticipante', $numeroIdParticipante, PDO::PARAM_INT);
     }
     else
     {
         echo '<script>alert("El participante no se puede eliminar \n El participante tiene compromisos asignados...");</script>';
     }
   
     $s_idReunion           = $_POST['idReunion']; 
     $s_existe              = $_POST['existe'];
     $s_yaGrabo             = $_POST['yaGrabo'];
    }     
 
    if(isset($_POST['adicionarPrticipante']))
    {
        $s_idReunion    = $_POST['idReunion']; 
        $s_participante = $_POST['participante'];
        $s_yaGrabo      = $_POST['yaGrabo'];
        $s_existe       = $_POST['existe']; 
        
        // Inserción de datos
        $stmt = $pdo->prepare('INSERT INTO reu_reuniones_participante (idreunion, numeroidparticipante) VALUES (?, ?)');
        $stmt->execute([$s_idReunion, $s_participante]);
        
        $mensaje=" <b>Atención!</b> Grabación exitosa ¡";
    }
    
    if ( $s_idReunion != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "MODIFICAR REUNION";
      $s_existe = 1;
      $boton  = "Actualizar";
    
      $sql = "select * from reu_reuniones where idreunion=$s_idReunion";
      $stmt = $pdo->query($sql);
      $row  = $stmt->fetch(PDO::FETCH_ASSOC);
    
      $s_idReunion       = $row['idreunion'];
      $s_fechaReunion    = $row['fechareunion'];
      $s_horaReunion     = $row['horareunion'];
      $s_lugarReunion    = $row['lugarreunion'];
      $s_convocadaPor    = $row['convocadapor'];
      $s_idEntidad       = $row['identidad'];
      $s_idDependencia   = $row['iddependencia'];
      $s_idGrupo         = $row['idgrupo'];
      $s_idCategoria     = $row['idcategoria'];
      $s_idSubCategoria  = $row['idsubcategoria'];
      $s_detalleReunion  = $row['detallereunion'];
      $s_desarrolloReunion = $row['desarrolloreunion'];
      $s_estadoReunion   = $row['estadoreunion'];
      $s_fechaEstado     = $row['fechaestado'];
        
      /*     
        echo "1.." . $s_idReunion;
        echo '<br>';
        echo "2.." . $s_fechaReunion;
        echo '<br>';
        echo "3.." . $s_horaReunion;
        echo '<br>';
        echo "4.." . $s_lugarReunion;
        echo '<br>';
        echo "5.." . $s_convocadaPor;
        echo '<br>';
        echo "6.." . $s_idEntidad;
        echo '<br>';
        echo "7.." . $s_idDependencia;
        echo '<br>';
        echo "8.." . $s_idGrupo;
        echo '<br>';
        echo "9.." . $s_idCategoria;
        echo '<br>';
        echo "10.." . $s_idSubCategoria;
        echo '<br>';
        echo "11.." . $s_detalleReunion;
        echo '<br>';
        echo "11 a.." . $s_desarrolloReunion;
        echo '<br>';
        echo "12.." . $s_estadoReunion;
        echo '<br>';
        echo "13.." . $s_fechaEstado;
        echo '<br>';
       */  
        
    }  
    else
    {
      $titulo = "NUEVA REUNION";
      $s_existe = 0;
      $boton="Grabar";
    }  
    
    
   if(isset($_POST['grabar']))
   { 
        $s_idReunion       = $_POST['idReunion'];
        $s_fechaReunion    = $_POST['fechaReunion'];
        $s_horaReunion     = $_POST['horaReunion'];
        $s_lugarReunion    = $_POST['lugarReunion'];
        $s_convocadaPor    = $_POST['convocadaPor'];
        $s_idEntidad       = $_POST['idEntidad'];
        $s_idDependencia   = $_POST['idDependencia'];
        $s_idGrupo         = $_POST['idGrupo'];
        $s_idCategoria     = $_POST['idCategoria'];
        $s_idSubCategoria  = $_POST['idSubCategoria'];
        $s_detalleReunion  = $_POST['detalleReunion'];
        $s_desarrolloReunion = $_POST['desarrolloReunion'];
        $s_estadoReunion   = $_POST['estadoReunion'];
        $s_fechaEstado     = $_POST['fechaEstado'];
        
        /*
        echo "1.." . $s_idReunion;
        echo '<br>';
        echo "2.." . $s_fechaReunion;
        echo '<br>';
        echo "3.." . $s_horaReunion;
        echo '<br>';
        echo "4.." . $s_lugarReunion;
        echo '<br>';
        echo "5.." . $s_convocadaPor;
        echo '<br>';
        echo "6.." . $s_idEntidad;
        echo '<br>';
        echo "7.." . $s_idDependencia;
        echo '<br>';
        echo "8.." . $s_idGrupo;
        echo '<br>';
        echo "9.." . $s_idCategoria;
        echo '<br>';
        echo "10.." . $s_idSubCategoria;
        echo '<br>';
        echo "11.." . $s_detalleReunion;
        echo '<br>';
        echo "11 a.." . $s_desarrolloReunion;
        echo '<br>';
        echo "12.." . $s_estadoReunion;
        echo '<br>';
        echo "13.." . $s_fechaEstado;
        echo '<br>';
   */
        $s_existe         = $_POST['existe'];
        $s_yaGrabo        = $_POST['yaGrabo'];
        $s_estadoReunion         = "A";
     
     /*
       A=Regiatrada
       B=Impresa
       C=Cerrada
     */
    
     date_default_timezone_set('America/Bogota');
     //$s_fecha  = date("Y-m-d",time());
     //$s_fecha  = date("Y/m/d H:i:s");
     $date_added=date("Y-m-d");
     
     ///MODIFICA
     if ($s_existe == "1")  
     {
        // Consulta preparada con marcadores de posición
        /*
        $sql = "UPDATE reu_reuniones SET  
                    fechareunion = :fechareunion, 
                    horareunion = :horareunion, 
                    lugarreunion = :lugarreunion, 
                    convocadapor = :convocadapor, 
                    identidad = :identidad, 
                    iddependencia = :iddependencia, 
                    idgrupo = :idgrupo, 
                    idcategoria = :idcategoria, 
                    idsubcategoria = :idsubCategoria, 
                    detallereunion = :detallereunion, 
                    desarrolloreunion = :desarrolloreunion 
                WHERE idreunion = :idreunion";
         */       
                
        $sql = "UPDATE reu_reuniones SET 
                    fechareunion = :fechareunion, 
                    horareunion = :horareunion, 
                    lugarreunion = :lugarreunion, 
                    convocadapor = :convocadapor, 
                    identidad = :identidad, 
                    iddependencia = :iddependencia, 
                    idgrupo = :idgrupo, 
                    idcategoria = :idcategoria, 
                    idsubcategoria = :idsubcategoria,
                    detallereunion = :detallereunion, 
                    desarrolloreunion = :desarrolloreunion 
                WHERE idreunion = :idreunion";        
       
        // Preparar la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fechareunion', $s_fechaReunion, PDO::PARAM_STR);
        $stmt->bindParam(':horareunion', $s_horaReunion, PDO::PARAM_STR);
        $stmt->bindParam(':lugarreunion', $s_lugarReunion, PDO::PARAM_STR);
        $stmt->bindParam(':convocadapor', $s_convocadaPor, PDO::PARAM_STR);
        $stmt->bindParam(':identidad', $s_idEntidad, PDO::PARAM_INT);
        $stmt->bindParam(':iddependencia', $s_idDependencia, PDO::PARAM_INT);
        $stmt->bindParam(':idgrupo', $s_idGrupo, PDO::PARAM_INT);
        $stmt->bindParam(':idcategoria', $s_idCategoria, PDO::PARAM_INT);
        $stmt->bindParam(':idsubcategoria', $s_idSubCategoria, PDO::PARAM_INT);
        $stmt->bindParam(':detallereunion', $s_detalleReunion, PDO::PARAM_STR);
        $stmt->bindParam(':desarrolloreunion', $s_desarrolloReunion, PDO::PARAM_STR);
        $stmt->bindParam(':idreunion', $s_idReunion, PDO::PARAM_INT);
       
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje=" <b>Atención!</b> Actualización exitosa";
        } else {
            $mensaje=" Error al intentar actualizar la reunión.";
        } 
     }  
      
      ///ADICIONA
      if ($s_existe == "0")
      {
        $sql = "SELECT MAX(idreunion) AS maximo FROM reu_reuniones";
        $stmt = $pdo->query($sql);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $s_maximo = $row['maximo'];
        
        $s_idReunion     = $s_maximo+1;
         
        // Consulta preparada con marcadores de posición
        $sql = "INSERT INTO reu_reuniones 
                (idreunion, fechareunion, horareunion, lugarreunion, convocadapor, 
                 identidad, iddependencia, idgrupo, idcategoria, idsubcategoria, 
                 detallereunion, desarrolloreunion, estadoreunion, fechaestado) 
                VALUES 
                (:idreunion, :fechareunion, :horareunion, :lugarreunion, :convocadapor, 
                 :identidad, :iddependencia, :idgrupo, :idcategoria, :idsubcategoria, 
                 :detallereunion, :desarrolloreunion, :estadoreunion, :fechaestado)";

        // Preparar la consulta
        $stmt = $pdo->prepare($sql);

        // Asignar valores a los marcadores de posición
        $stmt->bindParam(':idreunion', $s_idReunion, PDO::PARAM_INT);
        $stmt->bindParam(':fechareunion', $s_fechaReunion, PDO::PARAM_STR);
        $stmt->bindParam(':horareunion', $s_horaReunion, PDO::PARAM_STR);
        $stmt->bindParam(':lugarreunion', $s_lugarReunion, PDO::PARAM_STR);
        $stmt->bindParam(':convocadapor', $s_convocadaPor, PDO::PARAM_STR);
        $stmt->bindParam(':identidad', $s_idEntidad, PDO::PARAM_INT);
        $stmt->bindParam(':iddependencia', $s_idDependencia, PDO::PARAM_INT);
        $stmt->bindParam(':idgrupo', $s_idGrupo, PDO::PARAM_INT);
        $stmt->bindParam(':idcategoria', $s_idCategoria, PDO::PARAM_INT);
        $stmt->bindParam(':idsubcategoria', $s_idSubCategoria, PDO::PARAM_INT);
        $stmt->bindParam(':detallereunion', $s_detalleReunion, PDO::PARAM_STR);
        $stmt->bindParam(':desarrolloreunion', $s_desarrolloReunion, PDO::PARAM_STR);
        $stmt->bindParam(':estadoreunion', $s_estadoReunion, PDO::PARAM_STR);
        $stmt->bindParam(':fechaestado', $date_added, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje=" <b>Atención!</b> Grabación exitosa de la reunión ¡";
        } else {
            $mensaje=" <b>Atención!</b> Error al intentar insertar la reunión.";
            echo "Error al intentar insertar la reunión.";
        }
        $s_existe ="1";
      }
      $s_tocoBoton = "S";  
   }//grabar
   
   
   //============================= CONSULTA EL PERSONAL
  //============================================================================ 
  
    $stmt = $pdo->query('SELECT * from reu_participante order by nombresparticipante');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboParticipante .=" <option value=''>".'- Seleccione el participante -'."</option>";
      }
      if ($line['numeroidparticipante']==$s_convocadaPor)
      {
        $comboParticipante .=" <option value='".$line['numeroidparticipante']."' selected>".$line['nombresparticipante']." </option>"; 
      }
      $comboParticipante .=" <option value='".$line['numeroidparticipante']."'>".$line['nombresparticipante']."</option>"; 
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
      if ($line['identidad']==$s_idEntidad)
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
      if ($line['iddependencia']==$s_idDependencia)
      {
        $comboDependencia .=" <option value='".$line['iddependencia']."' selected>".$line['nombredependencia']." </option>"; 
      }
      $comboDependencia .=" <option value='".$line['iddependencia']."'>".$line['nombredependencia']."</option>"; 
      $i++; 
    }
   
   //============================= CONSULTA el LUGAR
   //============================================================================ 
    $stmt = $pdo->query('SELECT * FROM reu_lugares order by nombrelugar');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboLugar .=" <option value=''>".'- Seleccione el lugar -'."</option>";
      }
      if ($line['idlugar']==$s_lugarReunion)
      {
        $comboLugar .=" <option value='".$line['idlugar']."' selected>".$line['nombrelugar']." </option>"; 
      }
      $comboLugar .=" <option value='".$line['idlugar']."'>".$line['nombrelugar']."</option>"; 
      $i++; 
    }
   
  //============================= CONSULTA grupo interno
  //============================================================================ 
    $stmt = $pdo->query('SELECT * FROM reu_grupos_internos order by grupointerno');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboGrupo .=" <option value=''>".'-  Seleccione el grupo interno -'."</option>";
      }
      if ($line['idgrupointerno']==$s_idGrupo)
      {
        $comboGrupo .=" <option value='".$line['idgrupointerno']."' selected>".$line['grupointerno']." </option>"; 
      }
      $comboGrupo .=" <option value='".$line['idgrupointerno']."'>".$line['grupointerno']."</option>"; 
      $i++; 
    }
   
   //============================= CONSULTA categorias
  //============================================================================ 
   $stmt = $pdo->query('SELECT * from reu_categorias order by descategoriareunion');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboCategoria .=" <option value=''>".'-  Seleccione la categoria -'."</option>";
      }
      if ($line['idcategoriareunion']==$s_idCategoria)
      {
        $comboCategoria .=" <option value='".$line['idcategoriareunion']."' selected>".$line['descategoriareunion']." </option>"; 
      }
      $comboCategoria .=" <option value='".$line['idcategoriareunion']."'>".$line['descategoriareunion']."</option>"; 
      $i++; 
    }
  
    //============================= CONSULTA sub categorias
    //============================================================================ 
    $stmt = $pdo->query('SELECT * from reu_sub_categorias order by subcategoriareunion');
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboSubCategoria .=" <option value=''>".'-  Seleccione la subcategoria -'."</option>";
      }
      if ($line['idsubcategoriareunion']==$s_idSubCategoria)
      {
        $comboSubCategoria .=" <option value='".$line['idsubcategoriareunion']."' selected>".$line['subcategoriareunion']." </option>"; 
      }
      $comboSubCategoria .=" <option value='".$line['idsubcategoriareunion']."'>".$line['subcategoriareunion']."</option>"; 
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
                          <h3> <i class='fas fa-building' style='color:#2f79b9'></i> REUNIÓN </h3>
                       </div> 
                       
                       <div class="col-sm-6" align="right">  					  			 
                         <p style="font-size:12px;"><i class="fas fa-user"></i> <?=$_SESSION['nombre_perfil']?></p>
                         <a href="reu0.php" class="btn btn-default pull-right btn-md"><i class="fas fa-reply"></i> Regresar</a>							
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
                   <div class="form-group row">
	                 
        	         <div class='col-md-4'>
         		       <label>Fecha de reunión</label>
	         	       <input type="date" class="form-control" id="fechaReunion" name="fechaReunion" placeholder="Fecha de reunión" value="<?=$s_fechaReunion?>">
         		     </div>
         		     
         		     <div class='col-md-4'>
         		       <label>Hora de reunión</label>
	         	       <input type="time" class="form-control" id="horaReunion" name="horaReunion" placeholder="Hora de reunión" value="<?=$s_horaReunion?>">
         		     </div>
         		     
         		     <div class='col-md-4'> 
         		       <label>Ubicación</label>
	         	        <select <?=$active?> required class="form-control" name="lugarReunion">
                          <?php echo $comboLugar; ?>
                        </select> 
         		     </div>
         		      
         		     <div class='col-md-4'><br>
         		       <label>Convocada por</label>
	         	        <select <?=$active?> required class="form-control" name="convocadaPor">
                          <?php echo $comboParticipante; ?>
                        </select> 
         		     </div>
         		     
         		     <div class='col-md-4'><br>
         		       <label>Entidad</label>
	         	        <select <?=$active?> required class="form-control" name="idEntidad">
                          <?php echo $comboEntidad; ?>
                        </select> 
         		     </div>
         		     
         		     <div class='col-md-4'><br>
         		       <label>Dependencia</label>
	         	        <select <?=$active?> required class="form-control" name="idDependencia">
                          <?php echo $comboDependencia; ?>
                        </select> 
         		     </div>
         		     
         		     <div class='col-md-4'><br>
         		       <label>Grupo interno</label>
	         	        <select <?=$active?> required class="form-control" name="idGrupo">
                          <?php echo $comboGrupo; ?>
                        </select> 
         		     </div>
         		     
         		     <div class='col-md-4'><br>
         		       <label>Categoría</label>
	         	        <select <?=$active?> required class="form-control" name="idCategoria">
                          <?php echo $comboCategoria; ?>
                        </select> 
         		     </div>
         		     
         		     <div class='col-md-4'><br>
         		       <label>Sub Categoría</label>
	         	        <select <?=$active?> required class="form-control" name="idSubCategoria">
                          <?php echo $comboSubCategoria; ?>
                        </select> 
         		     </div>
        	     </div>    
        	     
        	       
        	      <div class="form-group row">
         		     <div class='col-md-12'><br>  
         		        <label>Tema de la Reunión</label>
         		        <textarea id="detalleReunion" name="detalleReunion" rows="2" class="form-control" ><?php echo $s_detalleReunion; ?></textarea>
         		     </div>    
         		  </div>
         		  
         		  <div class="form-group row">
         		     <div class='col-md-12'><br>  
         		        <label>Desarrollo de la Reunión</label>
         		        <textarea id="desarrolloReunion" name="desarrolloReunion" rows="6" class="form-control" ><?php echo $s_desarrolloReunion; ?></textarea>
         		     </div>    
         		  </div>
                </div> <!-- panel body -->	 
              
               <div class="modal-footer"> 
                <div class="col-sm-11" align="right">  					  			 
                  <button type="submit" name='grabar' class="btn btn-md btn-success"><i class="glyphicon glyphicon-refresh"></i> <?=$boton?> </button>
                </div>	 
              </div>
              
         
             <input style="visibility:hidden" name="idReunion" id="idReunion" value="<?=$s_idReunion?>"/>
             <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
             <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
              <input type="hidden" class="form-control" id="id_banner" value="<?php echo intval($s_idZona);?>" name="id_banner">
            </form>                                
        </div> <!-- content -->   
        
         <?php
           if ($s_idReunion > 0 )
           {
         ?>    
            
              <div class="container-fluid">
                <div class="panel panel-info">
	               <div class="panel-heading">
        	          <h4><i class="fas fa-user-friends" style='color:#2f79b9'></i> PARTICIPANTES </h4>
	               </div>
	        
                   <div class="panel-body" align="left">
                      <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">    
                         <div class="col-md-2">
                           Participante
                         </div>    
                         <div class="col-md-6">
	         	           <select <?=$active?> required class="form-control" name="participante">
                             <?php echo $comboParticipante; ?>
                           </select> 
                        </div>    
                        <div class="col-md-4">
                          <button type="submit" name='adicionarPrticipante' class="btn btn-md btn-primary"><i class="fas fa-user-friends"></i> Incluir participante </button>
                        </div> 
                         <input style="visibility:hidden" name="idReunion" id="idReunion" value="<?=$s_idReunion?>"/>
                         <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                         <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
                         <input type="hidden" class="form-control" id="id_banner" value="<?php echo intval($s_idZona);?>" name="id_banner">
                      </form>
                      
                      <hr>
                      <?php
                       $sql="select * from  reu_reuniones_participante where idreunion = $s_idReunion";
                       $stmt = $pdo->query($sql);
                      ?>
                      
                      <div class="panel-group" id="accordion">
                        <div class="panel panel-info" >
			              <?php
			                $i=1;
			                while ($row  = $stmt->fetch(PDO::FETCH_ASSOC)){
			                 $numeroIdParticipante=$row['numeroidparticipante'];
 			                 
 			                 $sql_par="SELECT * FROM reu_participante where numeroidparticipante=$numeroIdParticipante";
			                 $stmt_par = $pdo->query($sql_par);
			                 $row_par  = $stmt->fetch(PDO::FETCH_ASSOC);
			                 
			                 $nombre   = $row_par['nombresparticipante']; 
			                 
			                 $borrarP = $s_idReunion . "-" . $numeroIdParticipante ;
			                 $compromisoP = $s_idReunion . "-" . $numeroIdParticipante ;
			                 
			                 if (($i % 2) == 0) 
			                 {
    			         ?>    
    			               <div class="panel-heading" style="margin-top:5px;">
    			                  <h4 class="panel-title" style="font-size:12px;">
        			                 <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $i; ?>"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo number_format($numeroIdParticipante); ?> <br> <b><?php echo $nombre; ?></b></a>
       			                  </h4>
      			                </div>
      			        <?php
			                 } else {
			            ?>            
    			              <!--<div class="panel-heading" style="margin-top:5px; background-color:#3498db; color:#fff;">-->
    			              <div class="panel-heading" style="margin-top:5px;">     
    			                  <h4 class="panel-title" style="font-size:12px;">
        			                 <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $i; ?>"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo number_format($numeroIdParticipante); ?> <br> <b><?php echo $nombre; ?></b></a>
       			                  </h4>
      			                </div>
      			       <?php         
			                 }
      			        ?>
    			                <div id="<?php echo $i; ?>" class="panel-collapse collapse">
     			                    <table class='tablaResponsive table table-striped table-bordered table-hover' style="font-size:16px; color:#c0392b;"> 
    			                      <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">    
    			                         <tr>
    			                           <td>
    			                             <h5>Eliminar participante</h5>
    			                             <i class="fa fa-trash" aria-hidden="true"></i> <input class='btn btn-danger btn-sm' type='submit' id='borrar' name='borrar' value='<?=$borrarP?> '  style='width:40' onclick='return confirmar()'>   
    			                           </td>
    			                         </tr>
    			                        
     			                         <input style="visibility:hidden" name="idReunion" id="idReunion" value="<?=$s_idReunion?>"/>
                                         <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                                         <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
                                         <input type="hidden" class="form-control" id="id_banner" value="<?php echo intval($s_idZona);?>" name="id_banner">
    			                      </form>        
    			                    </table>     
    			                     
    			                     <table class='tablaResponsive table table-striped table-bordered table-hover' style="font-size:16px; color:#c0392b;">  
    			                      <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
    			                         <tr>
    			                             <td colspan="2" align="center" style="color:green;"><h5> INGRESE EL COMPROMISO PARA EL PARTICIPANTE: <b><?=$nombre?></b> </h5></td> 
    			                         </tr>    
    			                         <tr> 
    			                            <td align="left" width="10%">
    			                             <h5 style="color:green;">Fecha de compromiso</h5>
    			                             <input type="date" class="form-control" required id="fechaFinalCompromiso" name="fechaFinalCompromiso" placeholder="Fecha de compromiso" value="<?=$s_fechaFinalCompromiso?>">
    			                            </td>
    			                         
    			                            <td width="90%"> 
    			                               <h5 style="color:green;">Compromiso</h5>
    			                               <textarea class="form-control" id="compromisoTxt" name="compromisoTxt"  rows="3" required  style="text-transform:uppercase;"><?=$s_compromisoTxt?></textarea> 
    			                            </td>
    			                         </tr> 
    			                         <tr> 
    			                            <td colspan="2" align="center">
    			                              <button type="submit" name='compromiso' class="btn btn-md btn-success"><i class="fas fa-plus" aria-hidden="true"></i> Adcionar Compromiso</button>
    			                            </td>
    			                         </tr> 
    			                         
     			                         <input style="visibility:hidden" name="compromisoP" id="compromisoP" value="<?=$compromisoP?>"/>
    			                         <input style="visibility:hidden" name="idReunion" id="idReunion" value="<?=$s_idReunion?>"/>
                                         <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                                         <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
                                         <input type="hidden" class="form-control" id="id_banner" value="<?php echo intval($s_idZona);?>" name="id_banner">
    			                      </form>     
    			                      
    			                       
                                       <table class='tablaResponsive table table-striped table-bordered table-hover'>
    			                        <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SE LF']; ?>">
    			                          <tr> 
    			                            <td colspan="6" align="center">COMPROMISOS DE: <b><?=$nombre?></b></td>
    			                          </tr>
    			                          <tr class="info">
    			                          	<th>No.Compromiso</th>
					    			        <th>Fecha Compromiso</th>
					    			        <th>Compromiso</th>
					    			        <!--<th>Acciones Realizadas</th>-->
					    			        <th>Estado</th>
					    			        <th class='text-center'>Acciones</th>
				    			          </tr>   
    			                          <?php
    			                             $sqlCompromiso ="select * from reu_compromisos where idreunion=$s_idReunion and numeroidparticipante=$numeroIdParticipante ";
    			                             $stmtCompromiso = $pdo->query($sql);
                                             
                                             while ($rowCompromiso  = $stmtCompromiso->fetch(PDO::FETCH_ASSOC)){
			                                  $numeroIdParticipante   = $rowCompromiso['numeroidparticipante'];
			                                  $idCompromiso           = $rowCompromiso['idcompromiso']; 
			                                  $fechaInicialCompromiso = $rowCompromiso['fechainicialcompromiso']; 
			                                  $fechaFinalCompromiso   = $rowCompromiso['fechafinalcompromiso'];
			                                  $compromisoAdquirido    = $rowCompromiso['compromisoadquirido'];
			                                  //$tareasRealizadas       = $rowCompromiso['tareasRealizadas'];
			                                  $estado                 = $rowCompromiso['estado'];
			                                  
			                                  if ($estado==1){$s_estado="Asignado";}
			                                  if ($estado==2){$s_estado="EnCurso";}
			                                  if ($estado==3){$s_estado="Cumplido";}
			                                  if ($estado==4){$s_estado="Incumplido";}
			                                  
			                                  $borrarComp=$s_idReunion."-".$numeroIdParticipante."-".$idCompromiso;
			                                  
			                                  $lv   = $s_idReunion."/". $numeroIdParticipante. "/". $idCompromiso . "/MOD1234567890qwertyuiopasdfghjkl";
					                          $lVDX = base64_encode($lv);
			                             ?>
			                             
			                             <tr>	
  					                       <td><?php echo $idCompromiso; ?></td>
  					                       <td><?php echo $fechaFinalCompromiso; ?></td>
  					                       <td><?php echo $compromisoAdquirido; ?></td>
  					                       <!--<td><?php echo $tareasRealizadas; ?></td>-->
  					                       <td><?php echo $s_estado; ?></td>
  					                       <td class='text-center'>
  					                           <a href="reuT.php?LA=<?=$lVDX?>" class='btn btn-default' title='Ingresar tareas' ><i class="fas fa-check"></i> Ingresar Tareas</a> 
					                           <input class='btn btn-danger btn-sm' type='submit' id='borrarCompromiso' name='borrarCompromiso' value='<?=$borrarComp?> '  style='width:40' onclick='return confirmarCompromiso()'>  <i class="fa fa-trash" aria-hidden="true"></i>  
					                        </td>
					                     </tr> 
			                             <?php       
    			                             }    
    			                         ?>  
    			                         
    			                         <input style="visibility:hidden" name="compromisoP" id="compromisoP" value="<?=$compromisoP?>"/>
    			                         <input style="visibility:hidden" name="idReunion" id="idReunion" value="<?=$s_idReunion?>"/>
                                         <input style="visibility:hidden" name="yaGrabo" id="yaGrabo" value="<?=$s_yaGrabo?>"/>
                                         <input style="visibility:hidden" name="existe" id="existe" value="<?=$s_existe?>"/>
                                         <input type="hidden" class="form-control" id="id_banner" value="<?php echo intval($s_idZona);?>" name="id_banner">
    			                      </form>
      			                    </table>   
      			                    
      			                </div>
    			         <?php       
    			               
    			              $i=$i+1;
    			              
    			            }       
    			          ?>      
  			                  </div>
			               </div>
			               
                       
                   </div><!-- body --> 

		         
		<?php
		  }
		?>
              
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
  
   