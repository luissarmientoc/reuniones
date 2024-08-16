<?php
  // get_cities.php

  // Conectar a la base de datos
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
  include("head.php");
     
   // Obtener el ID del departamento enviado por AJAX
   $departamentoId = isset($_POST['departamento']) ? (int)$_POST['departamento'] : 0;
   echo '<br>';
   echo "el depto.." . $departamentoId;
   echo '<br>';
   
   
   
   /*
                        $sqlSol    = "select * from graerr_estado_solicitud where id=$estado_solicitud";
						$stmtSol   = $pdo->query($sqlSol);
					    $rowSol    = $stmtSol->fetch(PDO::FETCH_ASSOC);
					    $solicitud = $rowSol['estado_solicitud'];
 */					    

if ($departamentoId > 0) {
    // Preparar la consulta para obtener las ciudades del departamento seleccionado
    $stmt = $pdo->prepare("SELECT * FROM reu_municipios WHERE coddepto = :coddepto");
    $stmt->bindParam(':coddepto', $departamentoId, PDO::PARAM_INT);
    $stmt->execute();

    // Generar las opciones de ciudad
    $ciudades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ciudades as $ciudad) {
        echo "<option value=\"{$ciudad['codmunicipio']}\">{$ciudad['nommunicipio']}</option>";
    }
} else {
    echo '<option value="">Seleccionar</option>'; // Valor predeterminado si no hay resultados
}
?>
