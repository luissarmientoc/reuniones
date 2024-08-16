<?php
  // get_cities.php

  // Conectar a la base de datos
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
  include("head.php");
     
   // Obtener el ID del departamento enviado por AJAX
   $departamentoId = isset($_POST['departamento']) ? (int)$_POST['departamento'] : 0;

if ($departamentoId > 0) {
    // Preparar la consulta para obtener las ciudades del departamento seleccionado
    $stmt = $pdo->prepare("SELECT id, nombre FROM reu_municipios WHERE coddepto = :coddepto");
    $stmt->bindParam(':coddepto', $departamentoId, PDO::PARAM_INT);
    $stmt->execute();

    // Generar las opciones de ciudad
    $ciudades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ciudades as $ciudad) {
        echo "<option value=\"{$ciudad['id']}\">{$ciudad['nombre']}</option>";
    }
} else {
    echo '<option value="">Seleccionar</option>'; // Valor predeterminado si no hay resultados
}
?>
