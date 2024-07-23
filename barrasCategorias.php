<?php
    session_start();
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
    
    $s_fecIni = $_SESSION['fecha'];
    $s_fecFin = $_SESSION['fecha1'];
    
    $sqlCategorias =" select count(*) as cuantoscategorias,  descategoriareunion 
                      from reu_reuniones a, reu_categorias b 
                      where a.idCategoria=b.idcategoriareunion and fechareunion between '$s_fecIni' AND  '2024-12-31' group by b.idcategoriareunion";                      
    
    $stmt = $pdo->query($sqlCategorias);
    
    $i=1;
    while ($rowCat = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $cuantosCategorias = $rowCat['cuantoscategorias'];
      $categoriaReunion  = $rowCat['descategoriareunion'];    
     
      $cat[$i]= "{ name:'".$categoriaReunion."', y:" . $cuantosCategorias."},";	  
      $i=$i+1; 
    }//while valores                   
?>

<!DOCTYPE HTML>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
</head>
<body>
  <script src="js/highcharts1.js"></script>
  
  <div id="container5" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<script type="text/javascript">

// Create the chart
Highcharts.chart('container5', {
    chart: {
        type: 'pie'
    },
    
    title: {
        text: 'REUNIONES POR CATEGORIA'
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
                 echo  $cat[$j];
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


