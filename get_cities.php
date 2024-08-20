<?php
// get_cities.php

require_once 'config/db.php'; // Incluye la conexión a la base de datos
require_once 'config/conexion.php'; // Incluye la función de conexión

if (isset($_GET['department_id'])) {
    $department_id = intval($_GET['department_id']);
    $stmt = $conn->prepare("SELECT codmunicipio AS id, nommunicipio AS name FROM reu_municipios WHERE coddepto = ?");
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
