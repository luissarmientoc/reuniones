 
<?php
 session_start();
 
                        $_SESSION['user_id'] = 1; //$result_row->user_id;
		            	$_SESSION['user_name'] = "ADMIN.SISTEMA"; // $result_row->user_name;
                        $_SESSION['user_email'] = "admin@admin.co"; //$result_row->user_email;
                        $_SESSION['user_perfil'] = 1; //$result_row->perfil;
                        $_SESSION['user_firstname'] = "USUARIO"; //$result_row->firstname;
                        $_SESSION['user_lastname'] = "ADMINISTRADOR"; //$result_row->lastname;  
                        
                        $_SESSION['idUt'] = 99; //$result_row->idUt;
                        $_SESSION['nombreUt'] = "UNP"; //$result_row->nombreUt;  
                        
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
                        
 $nomUusuario = $_SESSION['user_name'];
 $emaiUsuario = $_SESSION['user_email'];
 $nomUsuarioI = $_SESSION['user_firstname'];
 $apeUsuarioI = $_SESSION['user_lastname'];      
 $idBodega    = $_SESSION['laBodega'];    
 $nomBodega   = $_SESSION['laTienda'];     

  include("head.php");
  
?>
<div class="container-fluid">
    <?php
      include("navbar.php");
    ?>  

            
          
</div>          