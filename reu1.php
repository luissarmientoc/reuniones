<?php
 
  session_start();
  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) 
  {
    header("location: login.php");
    exit;
  }
  
  $active_marca="active";
  $title="UNP | Reuniones";    
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
        
        echo "3..". $compromisoP ;
        echo '<br>';
        
        $partir  = explode ("-", $compromisoP);   
        $s_idReunion     = $partir[0];
        $s_participante     = $partir[1];
        
        date_default_timezone_set('America/Bogota');
        //$s_fecha  = date("Y-m-d",time());
        //$s_fecha  = date("Y/m/d H:i:s");
        $date_added=date("Y-m-d");
        
         $sql1 = "select max(idCompromiso) as maximo from reu_compromisos ";
         $query1 = mysqli_query($con, $sql1) ;  
         $row1=mysqli_fetch_array($query1);
        
          $s_idCompromiso     = $row1[maximo]+1;
        
        //estado ->1:Iniciado, 2:EnCurso, 3:Cumplido, 4:Incumplido 
        $s_estado = 1;
        $sql="insert into reu_compromisos (idReunion, numeroIdParticipante, idCompromiso, fechaInicialCompromiso, fechaFinalCompromiso, compromisoAdquirido, tareasRealizadas, estado) 
                                   VALUES ('$s_idReunion', '$s_participante', '$s_idCompromiso', '$date_added', '$s_fechaFinalCompromiso', '$s_compromiso', '', '$s_estado')";
         $query_new_insert = mysqli_query($con,$sql);
         
        
    }
    
    if(isset($_POST['borrarCompromiso']))
    {
        echo "entrararara";
       $borrarComp  = $_POST['borrarCompromiso'];
       $partir  = explode ("-", $borrarComp);   
       $reu     = $partir[0];
       $par     = $partir[1];
       $comp    = $partir[2];
       
       $sqlTarea = "select count(*) as ctsTareas from reu_tareas_realizadas where idReunion=$s_idReunion and numeroIdParticipante=$par and idCompromiso=$comp";
       echo $sqlTarea;
       $queryTarea = mysqli_query($con, $sqlTarea); 
       $rowTarea  = mysqli_fetch_array($queryTarea);
       $ctsTareas   = $rowTarea['ctsTareas']; 
       
       if ($ctsTareas==0)
       {
         $sqlDel  = "DELETE FROM reu_compromisos WHERE  idReunion=$reu and numeroIdParticipante= $par and idCompromiso=$comp";
         $delete1 = mysqli_query($con,$sqlDel);
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
     $sqlExisteComp = "select count(*) as existe from reu_compromisos 
                       where  idReunion=$reu and numeroIdParticipante=$par";
     $query1 = mysqli_query($con, $sqlExisteComp);  
     $row1=mysqli_fetch_array($query1);
     $s_existe     = $row1["existe"];
     
      
     if($s_existe==0)
     {
       $sqlDel  = "DELETE FROM reu_reuniones_participante WHERE  idReunion=$reu and numeroIdParticipante= $par";
       $delete1 = mysqli_query($con,$sqlDel);
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
        
        $sql="insert into reu_reuniones_participante (idReunion, numeroIdParticipante) VALUES ('$s_idReunion', '$s_participante')";
        $query_new_insert = mysqli_query($con,$sql);
    }
    
    if ( $s_idReunion != "" )
    {  
      ///////////////////////////////////////////////////////  
      ////// REALIZA LA CONSULTA DE LA marca SELECCIONADA 
      $titulo = "MODIFICAR REUNION";
      $s_existe = 1;
      $boton  = "Actualizar";
    
      $sql = "select * from reu_reuniones where idReunion=$s_idReunion";
      $query = mysqli_query($con, $sql);  
      $row=mysqli_fetch_array($query);
    
        $s_idReunion       = $row['idReunion'];
        $s_fechaReunion    = $row['fechaReunion'];
        $s_horaReunion     = $row['horaReunion'];
        $s_lugarReunion    = $row['lugarReunion'];
        $s_convocadaPor    = $row['convocadaPor'];
        $s_idEntidad       = $row['idEntidad'];
        $s_idDependencia   = $row['idDependencia'];
        $s_idGrupo         = $row['idGrupo'];
        $s_idCategoria     = $row['idCategoria'];
        $s_idSubCategoria  = $row['idSubCategoria'];
        $s_detalleReunion  = $row['detalleReunion'];
        $s_desarrolloReunion = $row['desarrolloReunion'];
        $s_estadoReunion   = $row['estadoReunion'];
        $s_fechaEstado     = $row['fechaEstado'];
        
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
     
      /////////////////////////////////////////////  
      ////// VERIFICA A EXISTENCIA DE LA marca
      /////////////////////////////////////////////
      //$sql   = "SELECT count(*) AS cuantos FROM marcas WHERE id_marca = $s_id_marca";
      //$query = mysqli_query($con, $sql);  
      //$row   = mysqli_fetch_array($query);
      
      ///MODIFICA
      if ($s_existe == "1")  
      {
         $query_update = mysqli_query($con,$sql); 
        
         $sql= "UPDATE reu_reuniones SET  fechaReunion='$s_fechaReunion', horaReunion='$s_horaReunion', lugarReunion='$s_lugarReunion', convocadaPor='$s_convocadaPor', 
                                         idEntidad='$s_idEntidad', idDependencia='$s_idDependencia', idGrupo='$s_idGrupo', idCategoria='$s_idCategoria', idSubCategoria='$s_idSubCategoria', 
                                         detalleReunion='$s_detalleReunion', desarrolloReunion='$s_desarrolloReunion' 
                        WHERE idReunion='$s_idReunion'";
        //  echo $sql;
         $query_new_update = mysqli_query($con,$sql);
         $mensaje=" <b>Atención!</b> Actualización exitosa";
      }  
      
      ///ADICIONA
      if ($s_existe == "0")
      {
        $sql1 = "select max(idReunion) as maximo from reu_reuniones ";
        $query1 = mysqli_query($con, $sql1);  
        $row1=mysqli_fetch_array($query1);
        
        $s_idReunion     = $row1[maximo]+1;
         
        $sql= "INSERT INTO reu_reuniones (idReunion, fechaReunion, horaReunion, lugarReunion, convocadaPor, 
                                         idEntidad, idDependencia, idGrupo, idCategoria, idSubCategoria, 
                                         detalleReunion, desarrolloReunion, estadoReunion, fechaEstado) 
               VALUES ('$s_idReunion', '$s_fechaReunion', '$s_horaReunion', '$s_lugarReunion', '$s_convocadaPor', 
                    '$s_idEntidad', '$s_idDependencia', '$s_idGrupo', '$s_idCategoria', '$s_idSubCategoria', 
                    '$s_detalleReunion', '$s_desarrolloReunion', '$s_estadoReunion', '$date_added')";

         //echo $sql;
         $query_new_insert = mysqli_query($con,$sql);
        $mensaje=" <b>Atención!</b> Grabación exitosa ¡";
        
        $s_existe ="1";
      }
      $s_tocoBoton = "S";  
   }//grabar
   
   
   //============================= CONSULTA EL PERSONAL
  //============================================================================ 
  $query_participante=mysqli_query($con,"select * from reu_participante order by nombresParticipante");
  $i=0;
   while ($line = mysqli_fetch_array($query_participante))
   {
    if ($i==0)
      {
        $comboParticipante .=" <option value=''>".'- Seleccione el participante -'."</option>";
      }

      if ($line['numeroIdParticipante']==$s_convocadaPor)
      {
        $comboParticipante .=" <option value='".$line['numeroIdParticipante']."' selected>".$line['nombresParticipante']." </option>"; 
      }
      else
      {
       $comboParticipante .=" <option value='".$line['numeroIdParticipante']."'>".$line['nombresParticipante']."</option>"; 
      }
    $i++; 
   }
   
   //============================= CONSULTA LA ENTIDAD
  //============================================================================ 
  $query_entidad=mysqli_query($con,"select * from reu_entidades order by nombreEntidad");
  $i=0;
   while ($line = mysqli_fetch_array($query_entidad))
   {
    if ($i==0)
      {
        $comboEntidad .=" <option value=''>".'- Seleccione la entidad -'."</option>";
      }

      if ($line['idEntidad']==$s_idEntidad)
      {
        $comboEntidad .=" <option value='".$line['idEntidad']."' selected>".$line['nombreEntidad']." </option>"; 
      }
    
      $comboEntidad .=" <option value='".$line['idEntidad']."'>".$line['nombreEntidad']."</option>"; 
    
    $i++; 
   }
   
  //============================= CONSULTA LA DEPENDENCIA
  //============================================================================ 
  $query_dependencia=mysqli_query($con,"select * from reu_dependencias order by nombreDependencia");
  $i=0;
   while ($line = mysqli_fetch_array($query_dependencia))
   {
    if ($i==0)
      {
        $comboDependencia .=" <option value=''>".'- Seleccione la dependencia -'."</option>";
      }

      if ($line['idDependencia']==$s_idDependencia)
      {
        $comboDependencia .=" <option value='".$line['idDependencia']."' selected>".$line['nombreDependencia']." </option>"; 
      }
    
      $comboDependencia .=" <option value='".$line['idDependencia']."'>".$line['nombreDependencia']."</option>"; 
    
    $i++; 
   } 
   
   //============================= CONSULTA el LUGAR
  //============================================================================ 
  $query_dependencia=mysqli_query($con,"select * from reu_lugares order by nombreLugar");
  $i=0;
   while ($line = mysqli_fetch_array($query_dependencia))
   {
    if ($i==0)
      {
        $comboLugar .=" <option value=''>".'- Seleccione la ubicación -'."</option>";
      }

      if ($line['idLugar']==$s_lugarReunion)
      {
        $comboLugar .=" <option value='".$line['idLugar']."' selected>".$line['nombreLugar']." </option>"; 
      }
      else
      {
       $comboLugar .=" <option value='".$line['idLugar']."'>".$line['nombreLugar']."</option>"; 
      }
    $i++; 
   } 
   
  //============================= CONSULTA grupo interno
  //============================================================================ 
  $query_grupo=mysqli_query($con,"select * from reu_grupos_internos order by grupoInterno");
  $i=0;
   while ($line = mysqli_fetch_array($query_grupo))
   {
    if ($i==0)
      {
        $comboGrupo .=" <option value=''>".'- Seleccione el grupo interno -'."</option>";
      }

      if ($line['idGrupoInterno']==$s_idGrupo)
      {
        $comboGrupo .=" <option value='".$line['idGrupoInterno']."' selected>".$line['grupoInterno']." </option>"; 
      }
      else
      {
       $comboGrupo .=" <option value='".$line['idGrupoInterno']."'>".$line['grupoInterno']."</option>"; 
      }
    $i++; 
   }
   
   //============================= CONSULTA categorias
  //============================================================================ 
  $query_categoria=mysqli_query($con,"select * from reu_categorias order by categoriaReunion");
  $i=0;
   while ($line = mysqli_fetch_array($query_categoria))
   {
    if ($i==0)
      {
        $comboCategoria .=" <option value=''>".'- Seleccione la categoría -'."</option>";
      }

      if ($line['idCategoriaReunion']==$s_idCategoria)
      {
        $comboCategoria .=" <option value='".$line['idCategoriaReunion']."' selected>".$line['categoriaReunion']." </option>"; 
      }
      else
      {
       $comboCategoria .=" <option value='".$line['idCategoriaReunion']."'>".$line['categoriaReunion']."</option>"; 
      }
    $i++; 
   }
   
    //============================= CONSULTA sub categorias
  //============================================================================ 
  $query_subcategoria=mysqli_query($con,"select * from reu_sub_categorias order by subCategoriaReunion");
  $i=0;
   while ($line = mysqli_fetch_array($query_subcategoria))
   {
    if ($i==0)
      {
        $comboSubCategoria .=" <option value=''>".'- Seleccione la sub categoría -'."</option>";
      }

      if ($line['idSubCategoriaReunion']==$s_idSubCategoria)
      {
        $comboSubCategoria .=" <option value='".$line['idSubCategoriaReunion']."' selected>".$line['subCategoriaReunion']." </option>"; 
      }
      else
      {
       $comboSubCategoria .=" <option value='".$line['idSubCategoriaReunion']."'>".$line['subCategoriaReunion']."</option>"; 
      }
    $i++; 
   }
   
  ?>
   
  
              <!-- Page Content Holder -->
              <div id="content">  
                  <!--- MENU CERRAR ---->
                  <nav class="navbar navbar-default">
                      <div class="container-fluid">
                          <div class="navbar-header">
                              <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                  <i class="fas fa-arrows-alt-h"></i>
                                  <span>Menú</span>                                
                              </button>              
                              
                          </div>
                       </div>
                  </nav>
                  <!--- FIN MENU CERRAR ---->
                  
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
                       $sql="select * from  reu_reuniones_participante where idReunion = $s_idReunion";
                       $query = mysqli_query($con, $sql);     
                      ?>
                      
                      <div class="panel-group" id="accordion">
                        <div class="panel panel-info" >
			              <?php
			                $i=1;
			                while ($row=mysqli_fetch_array($query)){
			                  $numeroIdParticipante=$row['numeroIdParticipante'];
 			                 
			                 $sql_par  = "SELECT * FROM reu_participante where numeroIdParticipante=$numeroIdParticipante";
			                 $query_par = mysqli_query($con, $sql_par);
                             $row_par  = mysqli_fetch_array($query_par);
			                 $nombre   = $row_par['nombresParticipante']; 
			                 
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
    			                             $sqlCompromiso ="select * from reu_compromisos where idReunion=$s_idReunion and numeroIdParticipante=$numeroIdParticipante ";
    			                             $queryCompromiso = mysqli_query($con, $sqlCompromiso); 
    			                             while ($rowCompromiso=mysqli_fetch_array($queryCompromiso)){
			                                  $numeroIdParticipante   = $rowCompromiso['numeroIdParticipante'];
			                                  $idCompromiso           = $rowCompromiso['idCompromiso']; 
			                                  $fechaInicialCompromiso = $rowCompromiso['fechaInicialCompromiso']; 
			                                  $fechaFinalCompromiso   = $rowCompromiso['fechaFinalCompromiso'];
			                                  $compromisoAdquirido    = $rowCompromiso['compromisoAdquirido'];
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
  
   