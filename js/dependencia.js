		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
 			var parametros={'action':'ajax','page':page,'q':q};						
			$("#loader").fadeIn('slow');
			$.ajax({
    			        data: parametros,
				//url:'./ajax/buscar_zonas.php?action=ajax&page='+page+'&q='+q,
				url:'./ajax/buscar_dependencia.php',
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
	function eliminar (id)
		{
		var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la dependencia?")){	
		$.ajax({
                  type: "GET",
                  url: "./ajax/buscar_dependencia.php",
                  data: "id="+id,"q":q,
		  beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
	 	$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		
	
 
