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
  
  <body onload="window.print();">        
  
  <?php  
        // Crear una nueva instancia de conexión PDO
        $pdo = new PDO($dsn);    
   
        $s_LA    = $_GET['LA'];
        $linDeco = base64_decode($s_LA);
        //PARTE LA LINEA
        $partir      = explode ("/", $linDeco);   
        $s_idReunion   = $partir[0];
        $tipAccion     = $partir[1];
    
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
        $s_desarrolloReunion  = $row['desarrolloreunion'];
        $s_estadoReunion   = $row['estadoreunion'];
        $s_fechaEstado     = $row['fecharstado'];
        
        $lv   = $s_idReunion. "/MOD1234567890qwertyuiopasdfghjkl";
		$lVDX = base64_encode($lv);
					    
        //trae lugar
		$sqlLugar  ="select nombrelugar from reu_lugares where idlugar=$s_lugarReunion";
		$stmtLugar = $pdo->query($sqlLugar);
		$rowLugar  = $stmtLugar->fetch(PDO::FETCH_ASSOC);
		$nombreLugar = $rowLugar['nombrelugar'];

        //trae persona
		$sqlResponsable   = "select nombresparticipante from reu_participante where numeroidparticipante=$s_convocadaPor";
		$stmtResponsable = $pdo->query($sqlResponsable);
		$rowResponsable  = $stmtResponsable->fetch(PDO::FETCH_ASSOC);
		$responsable     = $rowPer['nombresparticipante'];
        
        $sqlC = "SELECT count(*) AS cuantos FROM reu_reuniones_participante where idreunion=$s_idReunion";
        $stmtC = $pdo->query($sqlC);
        $rowC  = $stmtC->fetch(PDO::FETCH_ASSOC);
        $count = $rowC['cuantos'];
        
		if ($count==0)
		{
		  $mesg="La reunión no tiene participantes registrados";    
		}    
		
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
              $sqlCompromiso ="select * from reu_compromisos where idreunion=$s_idReunion order by numeroidparticipante";
		      $stmtCompromiso = $pdo->query($sqlCompromiso);
		      $rowCompromiso  = $stmtCompromiso->fetch(PDO::FETCH_ASSOC);
		      
    		  $i=1;
    		  while ($rowCompromiso  = $stmtCompromiso->fetch(PDO::FETCH_ASSOC)){
			     $numeroIdParticipante   = $rowCompromiso['numeroidparticipante'];
			     $idCompromiso           = $rowCompromiso['idcompromiso']; 
			     $fechaInicialCompromiso = $rowCompromiso['fechainicialcompromiso']; 
			     $fechaFinalCompromiso   = $rowCompromiso['fechafinalcompromiso'];
			     $compromisoAdquirido    = $rowCompromiso['compromisoadquirido'];
			     $tareasRealizadas       = $rowCompromiso['tareasrealizadas'];
			     $estado                 = $rowCompromiso['estado'];
			     
			     if ($estado==1){$s_estado="Asignado";}
			     if ($estado==2){$s_estado="EnCurso";}
			     if ($estado==3){$s_estado="Cumplido";}
			     if ($estado==4){$s_estado="Incumplido";}
			     
			     //trae persona
		         $sqlResponsable   = "select nombresparticipante from reu_participante where numeroidparticipante=$s_convocadaPor";
		         $stmtResponsable = $pdo->query($sqlResponsable);
		         $rowResponsable  = $stmtResponsable->fetch(PDO::FETCH_ASSOC);
		         $responsableC     = $rowResponsable['nombresparticipante'];
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
              $sql  ="select * from  reu_reuniones_participante where idreunion = $s_idReunion";
              $stmt = $pdo->query($sql);
              
              $i=1;
			  while ($row  = $stmt->fetch(PDO::FETCH_ASSOC)){
			     $numeroIdParticipante=$row['numeroidparticipante'];
 			                 
			     $sql_par  = "SELECT * FROM reu_participante where numeroidparticipante=$numeroIdParticipante";
			     $stmt_par = $pdo->query($sql_par);
			     $row_par  = $stmt_par->fetch(PDO::FETCH_ASSOC);
			     
			     $nombre              = $row_par['nombresparticipante']; 
			     $celularParticipante = $row_par['celularparticipante']; 
			     $correoParticipante  = $row_par['correoparticipante']; 
			     $entidad             = $row_par['entidad']; 
			     $dependencia         = $row_par['dependencia']; 
			     $departamento        = $row_par['departamento']; 
			     $ciudad              = $row_par['ciudad']; 
			     $cargo               = $row_par['cargo']; 
			     /*
			     //ciudad
			     $sql1="select * from sl_municipios where codDepto=$departamento and codMunicipio=$ciudad ";
			     $query1 = mysqli_query($con, $sql1);
                 $row1   = mysqli_fetch_array($query1);
			     $nomMunicipio = $row1['nomMunicipio']; 
			     */
			     
			    //trae entidad
				$sqlEnt  ="select * from reu_entidades where identidad='$entidad'";
				// echo $sqlEnt;
				$stmtEnt = $pdo->query($sqlEnt);
				$rowEnt  = $stmtEnt->fetch(PDO::FETCH_ASSOC);
				$nombreEntidad     = $rowEnt['nombreentidad'];
                  
			     
			    //trae dependencia
				$sqlDep  ="select * from reu_dependencias where iddependencia=$dependencia";
				$stmtDep = $pdo->query($sqlDep);
				$rowDep  = $stmtDep->fetch(PDO::FETCH_ASSOC);
    			$nombreDependencia     = $rowDep['nombredependencia'];
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
			
		<!--	<tr>
			  <td colspan="9">
			     <a href="actaImpresion.php?LA=<?=$lVDX?>" target="_blank" type="button" class="btn btn-success btn-block"><i class="fas fa-print"></i> Imprimir <br> Acta</a>       
			 </td> 
            </tr>   -->
        </table>   
        
        <table class='tablaResponsive table table-striped table-bordered table-hover' style="font-size:9px;">
            <tr align="left" style="background-color:#ecf0f1;">
                <td colspan="3"><b>Elaborado por:</b></td>
            </tr>  
            <tr align="left" style="background-color:#ecf0f1;">
                <td colspan="3"><b>Archivese en:</b></td>
            </tr>
            
            <tr style="background-color:#ecf0f1;">
                <td align="left" >GOT-FT-23/V2</b></td>
                <td align="left" >Oficialización: 15/08/2023</b></td>
                <td align="right" >Página: 2</b></td>
            </tr>
            
        </table>    
     </div>
  </body>   
</html>  
  
  