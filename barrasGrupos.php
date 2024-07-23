<?php
    session_start();
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    
    $s_fecIni = $_SESSION['fecha'];
    $s_fecFin = $_SESSION['fecha1'];
               
    $sqlGrupos = "select count(*) as cuantosGrupos, grupoInterno 
                  from reu_reuniones a, reu_grupos_internos b 
                  where a.idgrupo=b.idGrupoInterno and fechaReunion between '$s_fecIni' AND  '2$s_fecFin' group by b.grupoInterno";            
                 
    $stmt = $pdo->query($sqlGrupos);
    
    $i=1;
    while ($rowGru = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $cuantosGrupos     = $rowGru['cuantosGrupos'];
      $grupoInterno      = $rowGru['grupoInterno'];    
     
      $gru[$i]= "{ name:'".$grupoInterno."', y:" . $cuantosGrupos."},";	  
      $i=$i+1; 
    }//while valores                   
?>

<!DOCTYPE HTML>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
</head>
<body>
  <script src="js/highcharts1.js"></script>
  
  <div id="container4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

// Create the chart
Highcharts.chart('container4', {
    chart: {
        type: 'bar'
    },
    
    title: {
        text: 'REUNIONES POR GRUPO'
    },
    subtitle: {
        text: 'REALIZADAS'
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
                 echo  $gru[$j];
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


