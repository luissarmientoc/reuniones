<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocultar div</title>
    <style>
        #miDiv {
            width: 200px;
            height: 100px;
            background-color: lightblue;
            display: block; /* Inicialmente visible */
        }
    </style>
</head>
<body>

    <select id="miSelect">
        <option value="mostrar">Mostrar</option>
        <option value="ocultar">Ocultar</option>
    </select>

    <div id="miDiv">
        Este es el contenido de la div.
    </div>

    <script>
        // Espera a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function() {
            const miSelect = document.getElementById('miSelect');
            const miDiv = document.getElementById('miDiv');

            miSelect.addEventListener('change', function() {
                const seleccion = this.value;

                if (seleccion === 'ocultar') {
                    miDiv.style.display = 'none';
                } else {
                    miDiv.style.display = 'block';
                }
            });
        });
    </script>

</body>
</html>
