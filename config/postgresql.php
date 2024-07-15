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
    
    /*
    
    // Ejemplo de inserción de datos
    $stmt = $pdo->prepare('INSERT INTO tabla (nombre, edad) VALUES (?, ?)');
    $stmt->execute(['Juan', 30]);
    
    echo "Datos insertados correctamente.";
    */
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

?>  