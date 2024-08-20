<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas Dependientes</title>
    <script>
        function loadCities() {
            var departmentId = document.getElementById('departments').value;
            alert(departmentId); // Corrige la sintaxis del alert

            if (!departmentId) {
                // Si no hay un departamento seleccionado, limpia las opciones de la ciudad
                document.getElementById('cities').innerHTML = '<option value="">Selecciona una ciudad</option>';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_cities.php?department_id=' + encodeURIComponent(departmentId), true);
            xhr.onload = function() {
                if (this.status === 200) {
                    try {
                        alert ("en el try");
                        var cities = JSON.parse(this.responseText);
                        var citiesSelect = document.getElementById('cities');
                        var options = '<option value="">Selecciona una ciudad</option>'; // Inicializa con opción predeterminada
                        for (var i = 0; i < cities.length; i++) {
                            options += '<option value="' + cities[i].id + '">' + cities[i].name + '</option>';
                        }
                        citiesSelect.innerHTML = options;
                    } catch (e) {
                        console.error('Error al analizar JSON:', e);
                    }
                } else {
                    console.error('Error al cargar ciudades:', this.status, this.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Error en la solicitud');
            };
            xhr.send();
        }
    </script>
</head>

<?php
    // Código PHP para generar opciones de departamentos
            require_once 'config/db.php'; // Incluye la conexión a la base de datos
            require_once 'config/conexion.php'; // Incluye la función de conexión
    //============================= CONSULTA LOS DEPARTAMENTOS
    //============================================================================ 
     // Crear una nueva instancia de conexión PDO
   $pdo = new PDO($dsn);
    
    $stmt = $pdo->query('SELECT coddepto, nomdepto  FROM reu_municipios GROUP BY coddepto, nomdepto;');
  
    $i=0;
    while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if ($i==0)
      {
        $comboDepto .=" <option value=''>".'- Seleccione el departamento -'."</option>";
      }
      if ($line['coddepto']==$departamento)
      {
        $comboDepto .=" <option value='".$line['coddepto']."' selected>".$line['nomdepto']." </option>"; 
      }
      $comboDepto .=" <option value='".$line['coddepto']."'>".$line['nomdepto']."</option>"; 
      $i++; 
    }
?>

<body>
    <form>
        
                                <label for="departamento">DEPARTAMENTO</label>
                                <select id="departments" name="departments" onchange="loadCities()">
                                <!--<select required class="form-control" name="departments" id="departments" onchange="loadCities(this.value)">-->
                                        <?php echo $comboDepto; ?>
                                </select>
                                
        

        <br><br>

        <label for="cities">Ciudad:</label>
        <select id="cities" name="cities">
            <option value="">Selecciona una ciudad</option>
        </select>
    </form>
</body>
</html>
