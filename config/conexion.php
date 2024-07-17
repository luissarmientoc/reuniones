<?php
 require_once 'db.php';
/*
	# conectare la base de datos
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
*/   
 $H = POSTGRESQL_HOST;
 $P = POSTGRESQL_PORT;
 $N = POSTGRESQL_NAME;
 $U = POSTGRESQL_USER;
 $C = POSTGRESQL_PASS;
 
    try {
      echo '<br>';
      echo "try";
    // Cadena de conexión
    $dsn = "pgsql:host=$H;port=$P;dbname=$N;user=$U;password=$C";
   // echo '<br>';
  //    echo "linea..uuuuu..." . $dsn;
//    echo '<br>';
    // Crear una nueva instancia de conexión PDO
//    $pdo = new PDO($dsn);
    
    // Configurar el modo de error para excepciones
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "Conectado: ";
    
    /*
     
    // Ejemplo de consulta SELECT
    $stmt = $pdo->query('SELECT * FROM reu_categorias');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Nombre: {$row['des_categoriareunion']}<br />";
    }
    
    // Ejemplo de inserción de datos
    $stmt = $pdo->prepare('INSERT INTO tabla (nombre, edad) VALUES (?, ?)');
    $stmt->execute(['Juan', 30]);
    
    echo "Datos insertados correctamente.";
    */
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
    
    
    
?>
