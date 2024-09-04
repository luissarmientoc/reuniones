		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			var q1= $("#q1").val();
			var q2= $("#q2").val();
			var q3= $("#q3").val();	
			var q4= $("#q4").val();	
			var parametros={'action':'ajax','page':page,'q':q,'q1':q1,'q2':q2,'q3':q3, 'q4':q4,  };						
			$("#loader").fadeIn('slow');
			$.ajax({
    			data: parametros,
				url:'./ajax/buscar_graerr_amtsp.php',
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
	 
		
		
	
  