<?php
    session_start();
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    
    $s_fecIni = $_SESSION['fecha'];
    $s_fecFin = $_SESSION['fecha1'];
    
    $sqlReuniones = "SELECT count(*) as cuantosreuniones, nombreentidad 
                      FROM reu_reuniones a, reu_entidades b 
                      WHERE a.identidad = b.identidad and fechareunion between '$s_fecIni' AND  '$s_fecFin' group by b.nombreentidad";
    $stmt = $pdo->query($sqlReunion);
    
    $i=1;
    while ($rowCon = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $s_cuantosReuniones = $rowReu['cuantosReuniones'];
      $nombreEntidad      = $rowReu['nombreEntidad'];    
      
      $reu[$i]= "{ name:'".$nombreEntidad."', y:" . $s_cuantosReuniones."},";	  
      $i=$i+1; 
    }//while valores       
   

 ?>
 
<!DOCTYPE HTML>
<html>
  <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Reuniones</title>

      <style type="text/css">
      </style>
   </head>
<body>
  <script src="js/highcharts1.js"></script>
  <script src="js/highcharts2.js"></script>
  <script src="js/modules/data.js"></script>
  <script src="js/modules/drilldown.js"></script>


<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!--bar, column, line, pie, -->
<script type="text/javascript">

// Create the chart
Highcharts.chart('container1', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'REUNIONES POR ENTIDAD'
    },
    subtitle: {
        text: 'REALIZADAS'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Cantidad en #'
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
            name: "Producto",
            colorByPoint: true,
            data: [
              
              <?php
               $j=1;
               while ($j<=$i)
               {
                  
                 echo  $reu[$j];
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

