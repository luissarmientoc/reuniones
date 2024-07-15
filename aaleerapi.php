<?php

$s_LA    = $_GET['id_user'];
  //echo "Id enviado: " . $s_LA;
//echo "<br>";
//include("dash.php");
                        //header("Location: ini00.php");
                        $_SESSION['user_id'] = 1; //$result_row->user_id;
		            	$_SESSION['user_name'] = "ADMIN.SISTEMA"; // $result_row->user_name;
                        $_SESSION['user_email'] = "admin@admin.co"; //$result_row->user_email;
                        $_SESSION['user_perfil'] = 1; //$result_row->perfil;
                        $_SESSION['user_firstname'] = "USUARIO"; //$result_row->firstname;
                        $_SESSION['user_lastname'] = "ADMINISTRADOR"; //$result_row->lastname;  
                        
                        $_SESSION['idUt'] = 99; //$result_row->idUt;
                        $_SESSION['nombreUt'] = "UNP"; //$result_row->nombreUt;  

                        //$_SESSION['ip_add'] = $_SERVER['REMOTE_ADDR'];
                        //$laIp=$_SESSION['ip_add'];
                          
                        $_SESSION['user_login_status'] = 1;
                        
                        if ($_SESSION['user_perfil']==1)
                        {
                            $_SESSION['nombre_perfil']="ADMINISTRADOR";
                        }
                        if ($_SESSION['user_perfil']==3)
                        {
                            $_SESSION['nombre_perfil']="JURIDICO";
                        }
                        if ($_SESSION['user_perfil']==4)
                        {
                            $_SESSION['nombre_perfil']="FINANCIERO";
                        }
                        if ($_SESSION['user_perfil']==5)
                        {
                            $_SESSION['nombre_perfil']="UT";
                        }





/*  echo file_get_contents('http://ecosistemasesp.unp.gov.co/usuarios/api/usuario/luis.sarmiento');
//$data = json_decode( file_get_contents('http://ecosistemasesp.unp.gov.co/usuarios/api/usuario/luis.sarmiento/'), true );
//echo $data['email'];
header("Location: http://ecosistemasesp.unp.gov.co/usuarios/api/usuario/username:luis.sarmiento");*/


/*
prueba 1
   // URL o endpoint de la API 
    $url = 'https://nubecolectiva.com/api/v1/postres';
 
    // Iniciamos CURL en PHP 
    $curl = curl_init($url);
    echo "1.." . $curl;
    
 
    // Iniciamos la transferencia de datos con CURL en PHP 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
    // Pasamos un encabezado JSON a la petición de los datos 
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
 
    // Ejecutamos una sesión CURL y solicitamos los datos de la API 
    $datos = curl_exec($curl);    
    
    // Decodificamos los datos recibidos de la API
    $productos = json_decode($datos, true);
    echo "3.." . $productos;
    // Imprimimos los datos en la página web 
    print_r($productos);
 
    // Cerramos la sesión de CURL por seguridad 
    curl_close($curl);

https://nubecolectiva.com/api/v1/postres/
http://ecosistemasesp.unp.gov.co/usuarios/api/usuario/
*/

 /*
$url = 'https://nubecolectiva.com/api/v1/postres/';
$data = file_get_contents($url);
echo "data .." . $data;

if ($data === false) {
// Manejar el error
echo "no lee";
} else {
// Procesar los datos obtenidos de la API
$jsonData = json_decode($data, true);
echo '<br>';

echo "data .." . $jsonData;
echo '<br>';
var_dump($jsonData);

}
*/
//require("dash.php");
$array = array(0 => 'azul', 1 => 'rojo', 2 => 'verde', 3 => 'rojo');
$buscar="azul";
$clave = array_search($buscar, $array); // $clave = 2;
echo "la clave.." . $clave;
echo '<br>';
$clave = array_search('rojo', $array);  // $clave = 1;




// URL de la API
//$url = 'http://ecosistemasesp.unp.gov.co/usuarios/api/usuario/';
//$url = 'https://nubecolectiva.com/api/v1/postres/';
//$url = 'https://pokeapi.co/api/v2/pokemon/ditto';

//URL de la API de lectura
$url = 'https://softmakr.com/reuniones/config/usuarios.txt';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);
//echo "www." .$response;
//echo '<br>';

// Verificar si hubo algún error en la solicitud
if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

// Cerrar la conexión cURL
curl_close($ch);

// Decodificar la respuesta JSON
$data = json_decode($response, true);
echo "data .." .$data;
// Verificar si la decodificación fue exitosa
if ($data === null) {
    echo "Error al decodificar el JSON";
} else {
     
    // Procesar los datos obtenidos
    foreach ($data as $usuario) {
        $id         = $usuario['id'];
        $first_name = $usuario['first_name'];
        $last_name  = $usuario['last_name'];
        $email      = $usuario['email'];
        $username   = $usuario['username'];
        
        
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
        
        echo "<hr>";
    }
    echo "<hr>";echo "<hr>";echo "<hr>";echo "<hr>";echo "<hr>";echo "<hr>";
    
    
    
    //echo $response;
    
    $buscar = 13;
    $encontrado = false;
    
    foreach ($data as $usuario) {
        $id         = $usuario['id'];
        if ($id === $buscar) {
          $encontrado = true;
          $first_name = $usuario['first_name'];
          $last_name  = $usuario['last_name'];
          $email      = $usuario['email'];
          $username   = $usuario['username'];
          
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
          
          break;  // Detener el bucle una vez que se encuentra el valor
        }
    }

    if (!$encontrado) {
       echo "El valor '$buscar' no fue encontrado en el registro."; 
    }

    
    
}

    
?>




