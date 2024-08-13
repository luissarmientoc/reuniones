 
<style>
@-webkit-keyframes blinker {
  from {opacity: 1.0;}
  to {opacity: 0.0;}
}
.blink{
	text-decoration: blink;
	-webkit-animation-name: blinker;
	-webkit-animation-duration: 0.6s;
	-webkit-animation-iteration-count:infinite;
	-webkit-animation-timing-function:ease-in-out;
	-webkit-animation-direction: alternate;
}

/* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */
.wrapper {
    display: flex;
    align-items: stretch;
        width: auto;
}

#sidebar {
    min-width: 200px;
    max-width: 200px;
    background: #5A87C6; 
    color: #fff;
    transition: all 0.3s;
}

#sidebar.active {
    min-width: 85px;
    max-width: 85px;
    text-align: center;
}

#sidebar.active .sidebar-header h3, #sidebar.active .CTAs {
    display: none;
}

#sidebar.active .sidebar-header strong {
    display: block;
}

#sidebar ul li a {
    text-align: left;
}

#sidebar.active ul li a {
    padding: 20px 10px;
    text-align: center;
    font-size: 0.7em;
}

#sidebar.active ul li a i {
    margin-right:  0;
    display: block;
    font-size: 1.8em;
    margin-bottom: 5px;
}

#sidebar.active ul ul a {
    padding: 10px !important;
}

#sidebar.active a[aria-expanded="false"]::before, #sidebar.active a[aria-expanded="true"]::before {
    top: auto;
    bottom: 5px;
    right: 50%;
    -webkit-transform: translateX(50%);
    -ms-transform: translateX(50%);
    transform: translateX(50%);
}

#sidebar .sidebar-header {
    padding: 10px;
    background: #FFF;
}

#sidebar .sidebar-header strong {
    display: none;
    font-size: 1.5em;
}

#sidebar ul.components {
    padding: 10px 0;
    border-bottom: 1px solid #fff;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1em;
    display: block;
}
#sidebar ul li a:hover {
    color: #203864;
    background: #FFF;
}
#sidebar ul li a i {
    margin-right: 10px;
}

#sidebar ul li.active > a, a[aria-expanded="true"] {
    color: #FFF;
    background:#8E97B1;  
}

a[data-toggle="collapse"] {
    position: relative;
}

a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
    content: '\e259';
    display: block;
    position: absolute;
    right: 20px;
    font-family: 'Glyphicons Halflings';
    font-size: 0.6em;
}
a[aria-expanded="true"]::before {
    content: '\e260';
}

ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    color: #FFF;
    background: #34495e;
}

ul.CTAs {
    padding: 20px;
}

ul.CTAs a {
    text-align: left;
    font-size: 0.5em !important;
    display: block;
    border-radius: 5px;
    margin-bottom: 5px;
}

a.download {
    background: #fff;
    color: #7386D5;
}

a.article, a.article:hover {
    background: #363a41 !important;
    color: #fff !important;
}


</style>
<?php

 session_start();
 $nomUusuario = $_SESSION['user_name'];
 $emaiUsuario = $_SESSION['user_email'];
 $nomUsuarioI = $_SESSION['user_firstname'];
 $apeUsuarioI = $_SESSION['user_lastname'];   
 $user_perfil = $_SESSION['user_perfil'];
 $idUt        = $_SESSION['idUt'];
 $nombreUt    = $_SESSION['nombreUt'];    
 $laId        = $_SESSION['user_id']  

/* 
 echo "1.." .$nomUusuario;
 echo '<br>';
 echo "2.." .$emaiUsuario;
 echo '<br>';
 echo "3.." .$nomUsuarioI;
 echo '<br>';
 echo "4.." .$apeUsuarioI;   
 echo '<br>';
 echo "5.." .$idUt;    
 echo '<br>';
 echo "6.." .$nombreUt; 
 echo '<br>';
 echo "7.." .$user_perfil;
 echo '<br>';
*/ 
 
  

/* Connect To Database*/
  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos 
  
 /*
 $sql="select nombre_perfil from perfiles where id_perfil='$user_perfil'";
 $query = mysqli_query($con, $sql);                      
 $row  = mysqli_fetch_array($query);
 $perfilU  = $row['nombre_perfil']; 
 */
                      
  //MIRA LA CANTIDAD DE COMPRAS NUEVAS EN INTERNET
  /*  $sql="select count(*) as compras from pedidos_temporal where estadoPedido='G' group by id_temporal";   
   
  $query = mysqli_query($con, $sql);                      
  $row  = mysqli_fetch_array($query);
  $compras  = $row['compras'];  */ 
  
  /*
  $sql="select count(*) as compras from alertas_ecommerce where estado='1' ";
  $query = mysqli_query($con, $sql);                      
  $row  = mysqli_fetch_array($query);
  $compras  = $row['compras']; 
  */
   
  // $ip_add = $_SESSION['ip_add'];
  
  //Administrador = 1  
  //Supervisor de seguimiento = 2
  //Supervisor juridico = 3
  //Supervisor financiero = 4
  //UT = 5
   
                 
?>  
        <div class="wrapper">
            <!-- Sidebar Holder -->
            
            <nav id="sidebar">
                <!--
                <div class="sidebar-header" align="center">
                  <h3>
                     <span align="center" style="font-size:24px; color:#55bfdf;"><i class="fas fa-chart-line"></i>  </span>  
                    <span align="center" style="font-size:20px; color:#203864;"> UNIDAD DE PROTECCION NACIONAL</span>
                 </h3> 
                   <strong>UNP</strong>  
                     <span align="center" style="font-size:28px; color:#55bfdf;"><i class="fa fa-cogs"></i>  </span>                      
                     <img src="img/logoUNP.png" width="60%"/><br>                       
                       
                </div>
                -->
                
                <ul class="list-unstyled components">     
                    <span style="margin-left:5px;font-size:12px; color:#fff;"><b>REUNIONES</b>
                     <button type="button" id="sidebarCollapse" class="btn btn-link" style="color:#fff;">
                       <i class="fa fa-reorder"></i>
                      </button>  
                    </span>      
                
                <?php
                    if ($laId==14)
                     {
                ?>      
                
                  <li> 
                     <hr>
                        <a href="graerrFormulario0.php"> 0
                            <i class="glyphicon glyphicon-home"></i>
                            GRAERR
                        </a>
                        <hr>
                        <a href="graerrFormulario1.php"> 1
                            <i class="glyphicon glyphicon-home"></i>
                            GRAERR
                        </a>
                   </li> 
                <?php
                     }
                ?>     
                   
                  <li> 
                     <hr>
                        <a href="dash.php">
                            <i class="glyphicon glyphicon-home"></i>
                            Inicio
                        </a>
                   </li>
                    
                    <?php
                     // if ($user_perfil==1 or $user_perfil==2)
                     // {
                    ?>  
                     <li>
                        <!--<li class="active">-->
                        <a href="#grupos" data-toggle="collapse" aria-expanded="false">
                            <i class="fas fa-sitemap"></i> 
                            Grupos
                        </a>
                         <ul class="collapse list-unstyled" id="grupos">
                            
                            <li><a href="entidad0.php"><i class='fas fa-building' title="sddsdsd"></i> Entidades</a></li>
                            <li><a href="dependencia0.php"><i class='fas fa-gopuram'></i> Dependencias </a></li>
                            <li><a href="lugar0.php"><i class='fas fa-map-marker-alt'></i> Lugares </a></li>
                            <li><a href="grupos0.php"><i class='fas fa-project-diagram'></i> Grupos Internos</a></li>
                            <li><a href="categorias0.php"><i class='fas fa-stream'></i> Categorías</a></li>
                            <li><a href="subcategorias0.php"><i class='fas fa-tasks'></i>Sub Categorías</a></li> 
                             
                         </ul>
                      </li>
                    <?php
                    // }
                    ?>
                    
                     <li>
                    <!--<li class="active">-->
                        <a href="#personas" data-toggle="collapse" aria-expanded="false">
                            <i class="fas fa-user-friends"></i> 
                            Personas
                        </a>
                        
                        <ul class="collapse list-unstyled" id="personas">
                             <li><a href="participante0.php"><i class='fas fa-user-cog'></i> Participantes </a></li>
                        </ul>
                   </li>
                    
                    <li>
                    <!--<li class="active">-->
                        <a href="#reuniones" data-toggle="collapse" aria-expanded="false">
                            <i class="fas fa-marker"></i> 
                            Reuniones
                        </a>
                        
                        <ul class="collapse list-unstyled" id="reuniones">
                             <li><a href="reu0.php"><i class='fas fa-sign-in-alt'></i>Reuniones</a></li>
                        </ul>
                   </li>
                   
                   <li><a href="http://ecosistemasesp.unp.gov.co/"><i  class='fas fa-sign-in-alt fa-rotate-180' style='color:#fff' ></i>  Salir</a></li>
                    
                </ul>                               
            </nav>
            
        <!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
         </script>
    </body>
</html>

 