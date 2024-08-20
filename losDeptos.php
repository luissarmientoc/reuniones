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
<body>
    <form>
        <label for="departments">Departamento:</label>
        <select id="departments" name="departments" onchange="loadCities()">
            <option value="">Selecciona un departamento</option>
            <?php
            // Código PHP para generar opciones de departamentos
            require_once 'config/db.php'; // Incluye la conexión a la base de datos
            require_once 'config/conexion.php'; // Incluye la función de conexión

            $result = $conn->query("SELECT coddepto, nomdepto FROM re_municipios"); // Consulta los departamentos
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['coddepto'] . '">' . $row['nomdepto'] . '</option>';
            }
            ?>
        </select>

        <br><br>

        <label for="cities">Ciudad:</label>
        <select id="cities" name="cities">
            <option value="">Selecciona una ciudad</option>
        </select>
    </form>
</body>
</html>
