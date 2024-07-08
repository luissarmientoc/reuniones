<?php
    session_start();
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    
    $s_fecIni = $_SESSION['fecha'];
    $s_fecFin = $_SESSION['fecha1'];
    
    $sqlCompromisos   = "select count(*) as cuantosCompromisos, estado from reu_compromisos where fechaInicialCompromiso between '$s_fecIni' AND  '$s_fecFin' group by estado";
    $queryCompromisos = mysqli_query($con, $sqlCompromisos); 
     
     $i=$i+1;
     while ($lineCompromisos = mysqli_fetch_array($queryCompromisos))
    {
      $cuantosCompromisos = $lineCompromisos['cuantosCompromisos'];
      $estado             = $lineCompromisos['estado'];    
      
      if($estado==1)
      {
          $s_estado="ADQUIRIDOS";
      }
      else
      {
          $s_estado="CUMPLIDOS";
      }
      
     
      $comp[$i]= "{ name:'".$s_estado."', y:" . $cuantosCompromisos."},";	  
      $i=$i+1; 
    }//while valores              
?>

<!DOCTYPE HTML>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
</head>
<body>
  <script src="js/highcharts1.js"></script>
  
  <div id="container0A" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

// Create the chart
Highcharts.chart('container0A', {
    chart: {
        type: 'pie'
    },
    
    title: {
        text: 'COMPROMISOS'
    },
    subtitle: {
        text: 'EJECUCION'
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
                 echo  $comp[$j];
                  $j=$j+1;
                 
               }  
                
           ?>  
                   
              
            ]
        }
    ],
    
    
});
		</script>
	</body>
</html>


