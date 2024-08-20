<?php
  echo '<br>';
  echo "en php";
  echo '<br>';
  $q=$_POST['q'];
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
  // Crear una nueva instancia de conexi¨®n PDO
  $pdo = new PDO($dsn);
  
  $sql= "SELECT * FROM reu_municipios where coddepto=$q order by nommunicipio";
  echo '<br>';
  echo $sql;
  echo '<br>';
  
  $stmt = $pdo->query($sql);
  $i=0;
  while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
  {
     if ($i==0)
      {
        $comboCiudad .=" <option value=''>".'Seleccione el Municipio'."</option>";
      }
      $comboCiudad .=" <option value='".$line['codmunicipio']."'>".$line['nommunicipio']."</option>"; 
      $i++; 
   } 
 /*
  $query_ciudad=mysqli_query($con,"select * FROM sl_municipios WHERE codDepto=$q order by nomMunicipio");
  $i=0;
  while ($line = mysqli_fetch_array($query_ciudad))
  {
    if ($i==0)
      {
        $comboCiudad .=" <option value=''>".'Seleccione el Municipio'."</option>";
      }
    //  else
    //  {  
          $comboCiudad .=" <option value='".$line['codMunicipio']."'>".$line['nomMunicipio']."</option>"; 
    //  }
    $i++; 
  }
 */
?>

<select name="id_ciudad" id="id_ciudad" onchange="datoCiiu();" class="form-control" required>
  <?php echo $comboCiudad; ?>
</select>