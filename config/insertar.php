<?php
  
  $POSTGRESQL_HOST='172.16.20.121';
  $POSTGRESQL_PORT='5432';
  $POSTGRESQL_NAME='unp_reuniones';
  $POSTGRESQL_USER='usr_reuniones';
  $POSTGRESQL_PASS='Odisea1520sql';
  
  /*
  $POSTGRESQL_NAME='robert';
  $POSTGRESQL_USER='alban';
  $POSTGRESQL_PASS='Iliada1520psql(sqrt(pi))';
  */
  
  echo "algo"; 
  
  try {
    
    $s_idTarea=99;
    $s_idReunion=100;
    $s_numeroIdParticipante=79451305;
    $s_idCompromiso=12;
    $s_tareaRealizada="TRAER TRAER TRAER TRAER TRAER TRAER";
    $date_added=date("Y-m-d");
    $date_added="2024-01-01";
    $terminada="S";
    
    $sql = "INSERT INTO reu_tareas_realizadas 
                (idtarea, idreunion, numeroidparticipante, idcompromiso, tarearealizada, fechatarea, terminada) 
                VALUES (?,?,?,?,?,?)";
       $stmt->execute([$s_idTarea, $s_idReunion, $s_numeroIdParticipante, $s_idCompromiso, $s_tareaRealizada, $date_added,  $terminada ]);
    
    echo '<br>';
    echo "Datos insertados correctamente.";
    echo '<br>';
    
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

?>  