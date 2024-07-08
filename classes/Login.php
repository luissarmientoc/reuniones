<?php 

     require_once ("./config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
     require_once ("./config/conexion.php");//Contiene funcion que conecta a la base de datos
     
  ?>

<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                //$sql = "SELECT user_id, user_name, user_email, user_password_hash, perfil, firstname, lastname
                $sql = "SELECT *
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                        
                 $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {
                


                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {
                    
                                    echo "uno";echo "uno";echo "uno";echo "uno";echo "uno";echo "uno";

                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['user_id'] = $result_row->user_id;
		            	$_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_perfil'] = $result_row->perfil;
                        $_SESSION['user_firstname'] = $result_row->firstname;
                        $_SESSION['user_lastname'] = $result_row->lastname;  
                        
                        $_SESSION['idUt'] = $result_row->idUt;
                        $_SESSION['nombreUt'] = $result_row->nombreUt;  
                        
                        ECHO '<br>';ECHO '<br>';ECHO '<br>';
                        echo "ww.." . $_SESSION['nombreUt'];
                        
                        $_SESSION['ip_add'] = $_SERVER['REMOTE_ADDR'];
                        $laIp=$_SESSION['ip_add'];
                          
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
                        
                         date_default_timezone_set('America/Bogota');
                         $date_added=date("Y-m-d H:i:s");
                         
                         $sqlLog = "INSERT INTO users_log (idAcceso, user_name, fechaIngreso, ipIngreso) VALUES (NULL, '$user_name', '$date_added', '$laIP')";
                         echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
                         echo "ALGPOPPOPOP". $sqlLog;
                         $query_new_insert = mysqli_query($con,$sqlLog);
                        

                    } else {
                        $this->errors[] = "Usuario y/o contraseña no coinciden.";
                    }
                } else {
                    $this->errors[] = "Usuario y/o contraseña no coinciden.";
                }
            } else {
                $this->errors[] = "Problema de conexión de base de datos.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "Has sido desconectado.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
