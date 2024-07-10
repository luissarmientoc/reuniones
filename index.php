<!DOCTYPE html>
<html lang="en">
<head>
  <title>UNP Reuniones</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css' integrity='sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/' crossorigin='anonymous'>
    
</head>
<body>
    
<?php
session_start();
$buscar    = intval($_GET['id_user']);
//$buscar    = $_GET['id_user'];
echo "Id enviado: " . $buscar;
echo "<br>";


//http://ecosistemasesp.unp.gov.co/usuarios/api/usuario/
//URL de la API de lectura
//$url = 'https://softmakr.com/reuniones/config/usuarios.txt';
$url = 'ecosistemasesp.unp.gov.co/reuniones/config/usuarios.txt';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Verificar si hubo alg¨²n error en la solicitud
if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

// Cerrar la conexi¨®n cURL
curl_close($ch);

// Decodificar la respuesta JSON
$data = json_decode($response, true);

// Verificar si la decodificaci¨®n fue exitosa
if ($data === null) {
    echo "Error al decodificar el JSON";
} else {
    //$buscar = 1;
    $encontrado = false;
    //echo '<br>';
    //echo "buscar.." .$buscar;
    // Procesar los datos obtenidos
    foreach ($data as $usuario) {
        $id = $usuario['id'];
        if ($id === $buscar) {
          $encontrado = true;
          $first_name = $usuario['first_name'];
          $last_name  = $usuario['last_name'];
          $email      = $usuario['email'];
          $username   = $usuario['username'];
          
          $_SESSION['user_id']        = $id;
          $_SESSION['user_name']      = $username;
          $_SESSION['user_email']     = $email;
          $_SESSION['user_perfil']    = 1;//forzado admin
          $_SESSION['user_firstname'] = $first_name;
          $_SESSION['user_lastname']  = $last_name; 
          
          /*
          echo "1." .$id;
          echo '<br>';
          echo "2." .$first_name;
          echo '<br>';
          echo "3." .$last_name;
          echo '<br>';
          echo "4." .$email;
          echo '<br>';
          echo "5." .$username;
          echo '<br>';
          */
          break;  // Detener el bucle una vez que se encuentra el valor
        }
    } //foreach
    
    if (!$encontrado) {
       //echo "El valor '$buscar' no fue encontrado en el registro."; 
?>       
       <div class="container" align="center">
          <div class="alert alert-info">
              <h1><strong>ALERTA!</strong> </h1> 
              <h2>El Id: <?=$buscar?> </h2> 
              <h3>No fue encontrado en el registro.</h3>
              <a href="http://ecosistemasesp.unp.gov.co/" class="btn btn-primary btn-block"><i  class='fas fa-sign-in-alt'> </i> Regresar </a> 

           </div>  
       </div>
<?php       
    }
    else
    {
      include("dash.php");
    }
}//else    


?>




