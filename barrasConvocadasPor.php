<?php
    session_start();
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
     
     // Crear una nueva instancia de conexión PDO
     $pdo = new PDO($dsn);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     ECHO "ENTRA..!";
     echo'<br>';

    $s_fecIni = $_SESSION['fecha'];
    $s_fecFin = $_SESSION['fecha1'];

    $sql="SELECT count(*) as cuantosConvocado,  nombresParticipante 
                     FROM reu_reuniones a, reu_participante b 
                     WHERE a.convocadaPor= b.numeroIdParticipante 
                     AND fechaReunion between '$s_fecIni' AND  '$s_fecFin' 
                     GROUP BY a.convocadaPor, nombresParticipante";
echo "sql.." . $sql;                     
echo '<br>';
                     
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cantidad: {$row['cuantosConvocado']}<br />";
        echo "Nombre: {$row['nombresParticipante']}<br />";
    }

 ?>                   
