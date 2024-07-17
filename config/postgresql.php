<?php
 echo "algo";  echo "algo";  echo "algo";  echo "algo";  echo "algo";  echo "algo";  echo "algo"; 
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
      echo '<br>';
      echo "try";
    // Cadena de conexión
    $dsn = "pgsql:host=$POSTGRESQL_HOST;port=$POSTGRESQL_PORT;dbname=$POSTGRESQL_NAME;user=$POSTGRESQL_USER;password=$POSTGRESQL_PASS";
    echo '<br>';
    echo "linea.." . $dsn;
    echo '<br>';
    // Crear una nueva instancia de conexión PDO
    $pdo = new PDO($dsn);
    
    // Configurar el modo de error para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conectado: ";
    
    
     
    // Ejemplo de consulta SELECT
    $stmt = $pdo->query('SELECT * FROM reu_categorias');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Nombre: {$row['des_categoriareunion']}<br />";
    }
    
    
    // Ejemplo de inserción de datos
    $ID=30;
	$ENT="TTTTTTTTT";
    $stmt = $pdo->prepare('INSERT INTO reu_entidades (identidad, nombreentidad) VALUES (?, ?)');
    $stmt->execute([$ID, $ENT]);
    
    echo '<br>';
    echo "Datos insertados correctamente.";
    echo '<br>';
    
    // Ejmplo de modificación de datos
    
    // Consulta SQL de actualización con marcadores de posición
    $id_entidad = 4;  // ID del usuario a actualizar
    $nuevo_nombre = 'Melbourne'; 

    $sql = "UPDATE reu_entidades SET nombreentidad = :nombreentidad WHERE identidad = :$id_entidad";
    $stmt = $pdo->prepare($sql);
    
    // Vincular parámetros
    $stmt->bindParam(':nombreentidad', $nuevo_nombre, PDO::PARAM_STR);
    $stmt->bindParam(':identidad', $id_entidad, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Verificar el número de filas afectadas (opcional)
    $count = $stmt->rowCount();
    
    echo "Se actualizó el apellido correctamente.";
    
    
    
    
    
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

?>  