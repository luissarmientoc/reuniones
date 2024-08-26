<div class="container" style="margin-bottom:10px;">
                       <!--------------------------------------------------------- 
                       ---------------------------PREMESA Y SUBCOMISIÓN----------------------
                       ---------------------------------------------------------->
                       <div class="row" style="background-color:#5CB85C; color:#fff;" >
                           <div class="col-sm-12" align="center">
                               <h4>PREMESA Y SUBCOMISIÓN</h4>
                           </div>
                       </div>
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="tramite_emergencia">ES TRAMITE DE EMERGENCIA?</label>
                               <select class="form-control" id="es_tramite_emergencia" name="es_tramite_emergencia" required>
                                  <option value="">Seleccione la opción</option>
                                  <option value="si" <?=$siTramite?>>Sí</option>
                                  <option value="no" <?=$noTramite?>>No</option>
                               </select>
                           </div>
                           
                         <!--  <div id='emergencia' style="<?=$prendeEmergencia?>"> -->
                             <div class="col-sm-4" align="left">
                               <label for="tramite_emergencia">TRAMITE DE EMERGENCIA</label>
                               <input type="text" class="form-control" id="tramite_emergencia" name="tramite_emergencia" value="<?=$tramite_emergencia?>">
                             </div>
                             <div class="col-sm-4" align="left">
                               <label for="fecha_tramite_emergencia">FECHA TRAMITE DE EMERGENCIA</label>
                               <input type="date" class="form-control" id="fecha_tramite_emergencia" name="fecha_tramite_emergencia" value="<?=$fecha_tramite_emergencia?>">
                             </div>
                           </div>
                        <!-- </div>   -->
                       
                       <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-4" align="left">
                               <label for="ingreso_calidad">INGRESO A CALIDAD</label>
                               <input type="date" class="form-control" id="ingreso_calidad" name="ingreso_calidad" value="<?=$ingreso_calidad?>">
                           </div>
                           
                           <div class="col-sm-4" align="left">
                              <label for="fecha_aprobacion_calidad">FECHA APROBACION ASESOR TECNICO CALIDAD</label>
                              <input type="date" class="form-control" id="fecha_aprobacion_calidad" name="fecha_aprobacion_calidad" value="<?=$fecha_aprobacion_calidad?>">
                           </div>
                           <div class="col-sm-4" align="left">
                              <label for="fecha_presentacion_premesa">FECHA PRESENTACION PREMESA</label>
                              <input type="date" class="form-control" id="fecha_presentacion_premesa" name="fecha_presentacion_premesa" value="<?=$fecha_presentacion_premesa?>">
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           
                           <div class="col-sm-6" align="left">
                               <label for="recomendacion_medidas_premesa">RECOMENDACION DE MEDIDAS PREMESA</label>
                               <select <?=$active?>  class="form-control" name="recomendacion_medidas_premesa">
                                  <?php echo $combo_recomendacion_premesa; ?>
                               </select>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                              <label for="recomendacion_riesgo_premesa">RECOMENDACION DEL RIESGO PREMESA</label>
                              <textarea  style="text-transform:uppercase;" class="form-control" id="recomendacion_riesgo_premesa" name="recomendacion_riesgo_premesa" rows="5"> <?=$recomendacion_riesgo_premesa?> </textarea>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                               <label for="observaciones_premesa">OBSERVACIONES PREMESA</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="observaciones_premesa" name="observaciones_premesa" rows="5"> <?=$observaciones_premesa?> </textarea>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <!--
                           <div class="col-sm-3" align="left">
                               <label for="tiempo_gestion_graerr">TIEMPO GESTION GRAERR</label>
                               <input type="text" class="form-control" id="tiempo_gestion_graerr" name="tiempo_gestion_graerr" value="<?=$tiempo_gestion_graerr?>">
                           </div>
                           -->
                           <div class="col-sm-3" align="left">
                               <label for="remision_mesa_tecnica">REMISION MESA TECNICA</label>
                               <input type="date" class="form-control" id="remision_mesa_tecnica" name="remision_mesa_tecnica" value="<?=$remision_mesa_tecnica?>">
                           </div>
                           <!--
                           <div class="col-sm-3" align="left">
                               <label for="mes_remision">MES DE REMISION</label>
                               <input type="number" class="form-control" id="mes_remision" name="mes_remision" min="1" max="12" value="<?=$mes_remision?>">
                           </div>
                           <div class="col-sm-3" align="left">
                               <label for="ano_remision">AÑO DE REMISION</label>
                               <input type="number" class="form-control" id="ano_remision" name="ano_remision" min="1900" max="2099" value="<?=$ano_remision?>">
                           </div>
                           -->
                        </div> <!--row-->
                       
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                               <label for="observaciones">OBSERVACIONES</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="observaciones" name="observaciones" rows="5"> <?=$observaciones?> </textarea>
                           </div>
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-12" align="left">
                               <label for="otros">OTROS</label>
                               <textarea  style="text-transform:uppercase;" class="form-control" id="otros" name="otros" rows="5"> <?=$otros?> </textarea>
                           </div>
                           <!--
                           <div class="col-sm-6" align="left">
                               <label for="dev_traslados_poblacional">DEV/TRASLADOS POBLACIONAL</label>
                               <input type="text" class="form-control" id="dev_traslados_poblacional" name="dev_traslados_poblacional" value="">
                           </div>
                           -->
                        </div> <!--row-->
                        
                        <div class="row" style="margin-top:5px;"> 
                           <div class="col-sm-6" align="left">
                            </div>
                        </div>       
                    </div> <!--container-->