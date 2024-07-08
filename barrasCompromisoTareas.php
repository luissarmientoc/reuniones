<?php
   /*
    session_start();
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    
   $s_fecIni = $_SESSION['fecha'];
   $s_fecFin = $_SESSION['fecha1'];
    
    $sql = "select count(*) as cuantosCompromisos, nombresParticipante, estado, idCompromiso from reu_compromisos a, reu_participante b
                  where  a.numeroIdParticipante= b.numeroIdParticipante and fechaInicialCompromiso between '$s_fecIni' AND  '$s_fecFin' group by b.nombresParticipante ";
                  
    $query1 = mysqli_query($con, $sql); 
    $i=1;
    
    $compromiso = "categories:[";
    while ($row1 = mysqli_fetch_array($query1))
    {
      
      $idCompromiso         = $row1['idCompromiso'];
      $cuantosCompromisos   = $row1['cuantosCompromisos'];
      $nombresParticipante  = $row1['nombresParticipante'];    
     
      $compromiso = $compromiso . "'" . $nombresParticipante . "',";  
      echo "wwww..." . $compromiso;
      echo '<br>';
      
      
      
       
      /*$sqlTar = "select count(*) as cuantosTareas, estado from reu_tareas_realizadas 
                 where  idCompromiso = $idCompromiso group by idCompromiso ";  
      $queryTar = mysqli_query($con, $sqlTar);
      $k=1;
      while ($rowTar = mysqli_fetch_array($queryTar))
      {
         $cuantosTareas   = $row1['cuantosTareas'];  
         $estado          = $row1['estado']; 
         $k=k+1;
      }
      */
      $i=$i+1; 
      
      
    }//while valores          
             
    $compromiso = $compromiso . "'']"  ;
   echo "wwww..." . $compromiso;
      echo '<br>';
      
?>   



<!DOCTYPE HTML>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
</head>
<body>
  <script src="js/highcharts1.js"></script>
  
  <div id="container0" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

Highcharts.chart('container0', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Corn vs wheat estimated production for 2020',
        align: 'left'
    },
    subtitle: {
        text:
            'Source: <a target="_blank" ' +
            'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
        align: 'left'
    },
    xAxis: {
        
        <?php
          echo $compromiso;
        ?>
        
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '1000 metric tons (MT)'
        }
    },
    tooltip: {
        valueSuffix: ' (1000 MT)'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Corn',
            data: [406292, 260000, 107000, 68300, 27500, 14500]
        },
        {
            name: 'Wheat',
            data: [51086, 136000, 5500, 141000, 107180, 77000]
        }
        ,
         {
            name: 'Arroz',
            data: [71086, 156000, 7500, 161000, 127180, 97000]
        }
    ]
});

	</script>
	</body>
</html>

