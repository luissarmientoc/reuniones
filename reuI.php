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
   
        $s_LA    = $_GET['LA'];
        $linDeco = base64_decode($s_LA);
        //PARTE LA LINEA
        $partir      = explode ("/", $linDeco);   
        $s_idReunion   = $partir[0];
        $tipAccion     = $partir[1];
    
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
        $s_desarrolloReunion  = $row['desarrolloReunion'];
        $s_estadoReunion   = $row['estadoReunion'];
        $s_fechaEstado     = $row['fechaEstado'];
        
        
        $lv   = $s_idReunion. "/MOD1234567890qwertyuiopasdfghjkl";
		$lVDX = base64_encode($lv);
					    
        $sqlLugar   = "select nombreLugar from reu_lugares where idLugar=$s_lugarReunion";
        $queryLugar = mysqli_query($con, $sqlLugar);  
        $rowLugar   = mysqli_fetch_array($queryLugar);
        $nombreLugar = $rowLugar['nombreLugar'];

        $sqlResponsable   = "select nombresParticipante from reu_participante where numeroIdParticipante=$s_convocadaPor";
        $queryResponsable = mysqli_query($con, $sqlResponsable);  
        $rowResponsable   = mysqli_fetch_array($queryResponsable);
        $responsable      = $rowResponsable['nombresParticipante'];

        $query=mysqli_query($con, "select * from reu_reuniones_participante where idReunion='".$id_reunion."'");
		$count=mysqli_num_rows($query);
		if ($count==0)
		{
		  $mesg="La reunión no tiene participantes registrados";    
		}    
		
		//trae el lugar
        /*
        echo "1.." . $mesg;
        echo '<br>';
        echo "2.." . $s_idReunion;
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
        echo "12.." . $s_estadoReunion;
        echo '<br>';
        echo "13.." . $s_fechaEstado;
        echo '<br>';
    */
  ?>    
  
    <div class="container"> <br> 
        <table class='tablaResponsive table table-striped table-bordered table-hover'>
			<tr align="center">
			  <td rowspan="3" width="15%" style="vertical-align: middle;">
			    <img src="img/logoUNP.png" width="60%"/>  
			  </td> 
			  <td width="70%"><b>ACTA DE REUNIÓN</b></td>  
			  <td width="15%" rowspan="3" style="vertical-align: middle;">
			   <img src="img/escudoColombia.png" width="60%"/> 
			  </td> 
			</tr>    
			<tr>
			    <td align="center"><b>GESTIÓN DOCUMENTAL</b></td>  
			</tr>
			<tr>
			    <td align="center"><b>UNIDAD NACIONAL DE PROTECCIÓN</b></td>  
			</tr>
			 
        </table>
        
        <table class='tablaResponsive table table-striped table-bordered table-hover'>
          <tr align="center" style="background-color:#ecf0f1;">
              <td width="40%"><b>LUGAR</b></td> 
              <td width="20%"><b>FECHA</b></td>
              <td width="20%"><b>HORA INICIAL</b></td>
              <td width="20%"><b>HORA FINAL</b></td>
          </tr>
          <tr align="center">
              <td width="40%"><?=$nombreLugar?></td> 
              <td width="20%"><?=$s_fechaReunion?></td>
              <td width="20%"><?=$s_horaReunion?></td>
              <td width="20%">HORA FINAL</td>
          </tr>
          
          <tr align="center" style="background-color:#ecf0f1;">
               <td colspan="2"><b>TEMA</b></td> 
               <td colspan="2"><b>RESPONSABLE</b></td> 
          </tr>
          <tr align="left">
               <td colspan="2"><?=$s_detalleReunion?></td> 
               <td colspan="2"><?=$responsable?></td> 
          </tr>
            
          <tr align="center" style="background-color:#ecf0f1;">
               <td colspan="4">
                 <b> II. DESARROLLO Y CONCLUSIONES DE LA REUNIÓN</b> 
               </td> 
          </tr> 
          
          <tr align="left">
               <td colspan="4">
                 <?=$s_desarrolloReunion?>
               </td> 
          </tr> 
        </table> 
        
        <!--------- listado e compromisos ------->
        <table class='tablaResponsive table table-striped table-bordered table-hover' style="font-size:13px;">
            <tr align="center" style="background-color:#ecf0f1;">
                <td colspan="4"><b>III. COMPROMISOS (Si los hay)</b></td>
            </tr>    
            <tr align="center" style="background-color:#ecf0f1;">
                <td width="5%" align="center"><b>No.</b></td>
                <td width="60%"><b>COMPROMISO</b></td>
                <td width="10%"><b>FECHA</b></td>
                <td width="45%"><b>RESPONSABLE</b></td>
            </tr>
            <?php
              $sqlCompromiso ="select * from reu_compromisos where idReunion=$s_idReunion order by numeroIdParticipante";
    		  $queryCompromiso = mysqli_query($con, $sqlCompromiso); 
    		  $i=1;
    		  while ($rowCompromiso=mysqli_fetch_array($queryCompromiso)){
			     $numeroIdParticipante   = $rowCompromiso['numeroIdParticipante'];
			     $idCompromiso           = $rowCompromiso['idCompromiso']; 
			     $fechaInicialCompromiso = $rowCompromiso['fechaInicialCompromiso']; 
			     $fechaFinalCompromiso   = $rowCompromiso['fechaFinalCompromiso'];
			     $compromisoAdquirido    = $rowCompromiso['compromisoAdquirido'];
			     $tareasRealizadas       = $rowCompromiso['tareasRealizadas'];
			     $estado                 = $rowCompromiso['estado'];
			     
			     if ($estado==1){$s_estado="Asignado";}
			     if ($estado==2){$s_estado="EnCurso";}
			     if ($estado==3){$s_estado="Cumplido";}
			     if ($estado==4){$s_estado="Incumplido";}
			     
			     
			     $sqlResponsable   = "select nombresParticipante from reu_participante where numeroIdParticipante=$numeroIdParticipante";
                 $queryResponsable = mysqli_query($con, $sqlResponsable);  
                 $rowResponsable   = mysqli_fetch_array($queryResponsable);
                 $responsableC  = $rowResponsable['nombresParticipante'];
			      
            ?>
            <tr>	
  			  <td align="center"><?php echo $idCompromiso; ?></td>
  			  <td><?php echo $compromisoAdquirido; ?></td>
  			  <td><?php echo $fechaFinalCompromiso; ?></td>
              <td><?php echo $responsableC; ?></td>
  			</tr> 
  			
  		   <?php
  		       $i=$i+1;
    		 }
    	   ?>	  
        </table>    
        
        <table class='tablaResponsive table table-striped table-bordered table-hover' style="font-size:11px;">
            <tr align="center" style="background-color:#ecf0f1;">
                <td colspan="90"><b>IV. PARTICIPANTES</b></td>
            </tr>  
            
               <tr style="background-color:#ecf0f1;">
			       <td><b>NOMBRE</b></td>
			       <td><b>No.IDENTIFICACIÓN</b></td>
			       <td><b>CIUDAD</b></td>
			       <td><b>No.CONTACTO</b></td>
			       <td><b>CORREO ELECTRONICO</b></td>
			       <td><b>ENTIDAD</b></td>
			       <td><b>CARGO</b></td>
			       <td><b>DEPENDENCIA</b></td>
			       <td><b>FIRMA</b></td>
			   </tr>
			   
            <?php
              $sql="select * from  reu_reuniones_participante where idReunion = $s_idReunion";
              $query = mysqli_query($con, $sql);     
              
              $i=1;
			  while ($row=mysqli_fetch_array($query)){
			     $numeroIdParticipante=$row['numeroIdParticipante'];
 			                 
			     $sql_par  = "SELECT * FROM reu_participante where numeroIdParticipante=$numeroIdParticipante";
			     $query_par = mysqli_query($con, $sql_par);
                 $row_par  = mysqli_fetch_array($query_par);
			     
			     $nombre              = $row_par['nombresParticipante']; 
			     $celularParticipante = $row_par['celularParticipante']; 
			     $correoParticipante  = $row_par['correoParticipante']; 
			     $entidad             = $row_par['entidad']; 
			     $dependencia         = $row_par['dependencia']; 
			     $departamento        = $row_par['departamento']; 
			     $ciudad              = $row_par['ciudad']; 
			     $cargo               = $row_par['cargo']; 
			     
			     //ciudad
			     $sql1="select * from sl_municipios where codDepto=$departamento and codMunicipio=$ciudad ";
			     $query1 = mysqli_query($con, $sql1);
                 $row1   = mysqli_fetch_array($query1);
			     $nomMunicipio = $row1['nomMunicipio']; 
			     
			     //entidad
			     $sql2="select * from reu_entidades where idEntidad=$entidad ";
			     $query2 = mysqli_query($con, $sql2);
                 $row2   = mysqli_fetch_array($query2);
                 $nombreEntidad = $row2['nombreEntidad']; 
			     
			     //dependencia
			     $sql3="select * from reu_dependencias where idDependencia=$dependencia ";
			     $query3 = mysqli_query($con, $sql3);
                 $row3   = mysqli_fetch_array($query3);
			     $nombreDependencia = $row3['nombreDependencia']; 
			     
			?>   
			
			   <tr>
			       <td><?=$nombre?></td>
			       <td><?=$numeroIdParticipante?></td>
			       <td><?=$nomMunicipio?></td>
			       <td><?=$celularParticipante?></td>
			       <td><?=$correoParticipante?></td>
			       <td><?=$nombreEntidad?></td>
			       <td><?=$cargo?></td>
			       <td><?=$nombreDependencia?></td>
			       <td></td>
			   </tr>
			      
			<?php
			  }
			?>
			
			<tr>
			  <td colspan="9">
			     <a href="actaImpresion.php?LA=<?=$lVDX?>" target="_blank" type="button" class="btn btn-success btn-block"><i class="fas fa-print"></i> Imprimir <br> Acta</a>       
			 </td> 
            </tr>   
        </table>    
     </div>
     
</html>  
  
  