<?php
    session_start();
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    $s_fecIni = $_SESSION['fecha'];
    $s_fecFin = $_SESSION['fecha1'];
    
    $sqlConvocado = "SELECT count(*) as cuantosconvocado,  nombresparticipante 
                     FROM reu_reuniones a, reu_participante b 
                     WHERE a.convocadapor= b.numeroidparticipante 
                     AND fechareunion between '$s_fecIni' AND  '$s_fecFin' 
                     GROUP BY a.convocadapor, nombresparticipante";
    $stmt = $pdo->query($sqlConvocado);
    
    
    $i=1;
    while ($rowCon = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $s_cuantosConvocado = $rowCon['cuantosconvocado'];
      $nombresParticipante = $rowCon['nombresparticipante'];    
      
      $reu[$i]= "{ name:'".$nombresParticipante."', y:" . $s_cuantosConvocado."},";	  
      $alf[$i]= "{ name:'".$nombresParticipante."', y:" . $s_cuantosConvocado."},";
      $i=$i+1;
    }//while valores       


 ?>                   
 <!DOCTYPE HTML>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
</head>
<body>
  <script src="js/highcharts1.js"></script>
  
  <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

// Create the chart
Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    
    title: {
        text: 'REUNIONES'
    },
    subtitle: {
        text: 'CONVOCADAS POR'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Cantidad #'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                formatMoney: '{point.y:.1f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> del total<br/>'
    },

    "series": [
        {
            name: "Reuniones",
            colorByPoint: true,
            data: [
              
              <?php
               $j=1 ;
               while ($j<=$i)
               {
                 echo  $reu[$j];
                  $j=$j+1;
                  $k=1 ;
                   
               }  
                
               
           ?>  
                   
              
            ]
        }
    ],
    
    
});
		</script>
	</body>
</html>


