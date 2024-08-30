<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal para Dirección</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" />
   
    <style>
        .modal-content {
            border-radius: 8px;
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-footer {
            border-top: none;
        }
        
        .custom-modal-dialog {
            max-width: 80%; /* Ajusta el valor según el ancho deseado */
        }
        
        .labelDireccion {
               font-weight: bold;          /* Establece el texto en negrita */
               font-family: Arial, sans-serif; /* Usa la fuente Arial o sans-serif como alternativa */
               font-size: 12px;            /* Tamaño de fuente de 12px */
               text-align: center;         /* Centra el texto */
        }
    </style>
</head>
<body>
   
     <div class="container">   
       
        
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 80%; width: 80%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Datos de la Dirección</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- modal-header -->    
                    
                    <form id="addressForm"> <!-- Agregué un formulario para manejar la validación -->
                    <div class="modal-body" style="max-width: 90%; width: 90%;">
                         <hr>
                        <div class="row" style="margin:5px;">
                            <div class="col-sm-6">
                               <div class="form-group">
                                    <label class="labelDireccion" for="addressType">Tipo de dirección:</label>
                                    <select class="form-control" id="addressType" required>
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="">Seleccione una opción</option>
                                        <option value="rural">Rural</option>
                                        <option value="urbano">Urbano</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group" id="ruralOptions" style="display: none;">
                                     <label class="labelDireccion" for="ruralType">Tipo de rural:</label>
                                     <select class="form-control" id="ruralType">
                                         <option value="" disabled selected>Selecciona un tipo</option>
                                         <option value="corregimiento">Corregimiento</option>
                                         <option value="centro_poblado">Centro Poblado</option>
                                         <option value="vereda">Vereda</option>
                                         <option value="otro">Otro</option>
                                     </select>
                                </div>
                             
                                <div class="form-group" id="urbanoOptions" style="display: none;">
                                    <label class="labelDireccion" for="urbanoType">Tipo de urbano:</label>
                                    <select class="form-control" id="urbanoType">
                                        <option value="" disabled selected>Selecciona un tipo</option>
                                        <option value="tipo_via">Tipo de Vía</option>
                                        <option value="barrio">Barrio</option>
                                        <option value="campo_abierto">Campo Abierto</option>
                                    </select>
                                </div>
                            </div> 
                        </div><!--row-->
                        
                        <div class="row" style="margin:5px;">
                            <div class="col-sm-2">
                                <div class="form-group" id="tipo_via">
                                    <label class="labelDireccion" for="tipo_via">Tipo de vía:</label>
                                    <div class="form-group">
                                        <select <?=$active?> required class="form-control" id="tipo_via">
                                            <?=$combo_tipo_via?>
                                        </select>
                                    </div> 
                                </div>   
                            </div>
                            
                            <div class="col-sm-2">
                                <div class="form-group" id="cuadrante_tipo_via">
                                   <label class="labelDireccion" for="cuadrante_tipo_via">Cuadrante:</label>
                                   <div class="form-group">
                                     <select <?=$active?> required class="form-control" id="cuadrante">
                                         <?php echo $combo_cuadrante; ?>
                                      </select>
                                   </div> 
                                </div>  
                            </div>
                       
                            <div class="col-sm-2">
                                <div class="form-group" id="via_generadora">
                                   <label class="labelDireccion" class="labelDireccion" for="via_generadora">No. inical placa:</label>
                                   <input type="number" class="form-control" id="via_generadora" name="via_generadora" min="0" place holder="Vía Generadora">
                                </div>  
                            </div>
                            
                            <div class="col-sm-2">
                                <div class="form-group" id="letra_via_generadora">
                                   <label class="labelDireccion" for="letra_via_generadora">Letra:</label>
                                   <select class="form-control" id="letra_via_generadora" name="letra_via_generadora">
                                       <!-- Opciones del A a la Z -->
                                       <option value="">Seleccione una letra</option>
                                        <option value="A">A</option>
                                       <option value="B">B</option>
                                       <option value="C">C</option>
                                       <option value="D">D</option>
                                       <option value="E">E</option>
                                       <option value="F">F</option>
                                       <option value="G">G</option>
                                       <option value="H">H</option>
                                       <option value="I">I</option>
                                       <option value="J">J</option>
                                       <option value="K">K</option>
                                       <option value="L">L</option>
                                       <option value="M">M</option>
                                       <option value="N">N</option>
                                       <option value="O">O</option>
                                       <option value="P">P</option>
                                       <option value="Q">Q</option>
                                       <option value="R">R</option>
                                       <option value="S">S</option>
                                       <option value="T">T</option>
                                       <option value="U">U</option>
                                       <option value="V">V</option>
                                       <option value="W">W</option>
                                       <option value="X">X</option>
                                       <option value="Y">Y</option>
                                       <option value="Z">Z</option>
                                     </select>
                                   </div>  
                                </div> 
                                
                                <div class="col-sm-2">
                                    <div class="form-group" id="sufijo">
                                       <label class="labelDireccion" for="via_generadora">Sufijo:</label>
                                       <select class="form-control" id="sufijo" name="sufijo">
                                          <!-- Opciones del A a la Z -->
                                          <option value="">Seleccione el Sufijo</option>
                                          <option value="Bis">Bis</option>
                                        </select>          
                                    </div>  
                                </div>
                                
                                <div class="col-sm-2">
                                <div class="form-group" id="letra_sufijo">
                                   <label class="labelDireccion" for="letra_sufijo">Letra:</label>
                                   <select class="form-control" id="letra_sufijo" name="letra_sufijo">
                                       <!-- Opciones del A a la Z -->
                                       <option value="">Seleccione una letra</option>
                                        <option value="A">A</option>
                                       <option value="B">B</option>
                                       <option value="C">C</option>
                                       <option value="D">D</option>
                                       <option value="E">E</option>
                                       <option value="F">F</option>
                                       <option value="G">G</option>
                                       <option value="H">H</option>
                                       <option value="I">I</option>
                                       <option value="J">J</option>
                                       <option value="K">K</option>
                                       <option value="L">L</option>
                                       <option value="M">M</option>
                                       <option value="N">N</option>
                                       <option value="O">O</option>
                                       <option value="P">P</option>
                                       <option value="Q">Q</option>
                                       <option value="R">R</option>
                                       <option value="S">S</option>
                                       <option value="T">T</option>
                                       <option value="U">U</option>
                                       <option value="V">V</option>
                                       <option value="W">W</option>
                                       <option value="X">X</option>
                                       <option value="Y">Y</option>
                                       <option value="Z">Z</option>
                                     </select>
                                   </div>  
                                </div> 
                             </div><!--row-->
                       
                             <div class="row" style="margin:5px;">    
                                
                                <div class="col-sm-2">
                                    <div class="form-group" id="numero_placa">
                                        <label class="labelDireccion" for="numero_placa">Número de placa:</label>
                                         <input type="number" class="form-control" id="numero_placa" name="numero_placa" min="0">
                                    </div>  
                                </div>
                                 
                                <div class="col-sm-2">
                                    <div class="form-group" id="cuadrante_numero_placa">
                                      <label class="labelDireccion" for="cuadrante_numero_placa">Cuadrante:</label>
                                      <div class="form-group">
                                          <select <?=$active?> required class="form-control" id="cuadrante_numero_placa">
                                            <?php echo $combo_cuadrante; ?>
                                          </select>
                                      </div>
                                    </div>  
                                </div>
                                
                                <div class="col-sm-8">
                                    <div class="form-group" id="complemento">
                                      <label class="labelDireccion" for="complemento">Complemento:</label>
                                      <textarea  style="text-transform:uppercase;" class="form-control" id="complemento" name="complemento" rows="1">  </textarea>
                                    </div>  
                                </div>
                            </div>
                             <hr>
                        </div><!--row-->
                       
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                           <button type="submit" class="btn btn-primary" id="saveAddress">Guardar</button>
                        </div>
                    </div> <!-- modal-body -->    
                    </formA    
                </div> <!-- modal-content -->    
               
            </div> <!-- modal-dialog -->
        </div> <!-- modal -->
     </div> <!-- container -->

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script para mostrar opciones según el tipo seleccionado -->
    <script>
        document.getElementById('addressType').addEventListener('change', function() {
            const addressType = this.value;
            const ruralOptions = document.getElementById('ruralOptions');
            const urbanoOptions = document.getElementById('urbanoOptions');

            if (addressType === 'rural') {
                ruralOptions.style.display = 'block';
                urbanoOptions.style.display = 'none';
            } else if (addressType === 'urbano') {
                ruralOptions.style.display = 'none';
                urbanoOptions.style.display = 'block';
            } else {
                ruralOptions.style.display = 'none';
                urbanoOptions.style.display = 'none';
            }
        });

        document.getElementById('saveAddress').addEventListener('click', function() {
            // Obtener los valores de los campos
            const addressType = document.getElementById('addressType').value;
            const ruralType   = document.getElementById('ruralType') ? document.getElementById('ruralType').value : '';
            const urbanoType  = document.getElementById('urbanoType') ? document.getElementById('urbanoType').value : '';
            



            document.getElementById('direccionvv').value = concatenatedInfo;

            // Mostrar el valor de dirección y tipo seleccionado
            // console.log(`Dirección: ${direccion}`);
            // console.log(`Tipo de dirección: ${addressType}`);
            // console.log(`Tipo rural: ${ruralType}`);
            // nsole.log(`Tipo urbano: ${urbanoType}`);

            // Aquí podrías hacer algo con la dirección, como enviar el formulario o actualizar algún campo

            // Cerrar el modal
            $('#myModal').modal('hide');
        });
    </script>
    
    <script>
    // Validación en el submit del formulario
    document.getElementById('addressForm').addEventListener('submit', function(event) {
        // Verifica que los campos requeridos no estén vacíos
        let isValid = this.checkValidity();
        
        if (!isValid) {
            event.preventDefault(); // Evita que el formulario se envíe si no es válido
            alert('Por favor, complete todos los campos requeridos.');
        }
    }); 
   </script>
</body>
</html>
