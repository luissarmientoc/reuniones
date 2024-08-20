<?php
  // get_cities.php

  // Conectar a la base de datos
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
  include("head.php");
  
   echo '<br>';echo '<br>';echo '<br>';
   echo "entrar cities";
   echo '<br>';echo '<br>';echo '<br>';
     
   echo '<br>';
   echo "el depto.." . $_GET['department_id'];
   echo '<br>';

   if (isset($_GET['department_id'])) {
    $department_id = intval($_GET['department_id']);
    $stmt = $conn->prepare("SELECT codmunicipio, nommunicipio FROM reu_municipios WHERE coddepto = ?");
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = array();
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }

    echo json_encode($cities);
}
   
   
 	    


?>



