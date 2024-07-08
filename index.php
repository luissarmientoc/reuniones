<?php


$s_LA    = $_GET['id_user'];
echo "Id enviado: " . $s_LA;
echo "<br>";
include("dash.php");
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



?>
