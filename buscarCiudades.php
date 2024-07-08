<?php
  $q=$_POST['q']; 
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
 
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
 
?>

<select name="id_ciudad" id="id_ciudad" onchange="datoCiiu();" class="form-control" required>
  <?php echo $comboCiudad; ?>
</select>