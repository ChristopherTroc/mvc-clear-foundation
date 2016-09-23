<?

/***
 * Name: Helpers
 * Owner: C-troc
 * Description: This plugins have a lot of tools to manage your app
 * Modules:   - url_dispatcher
 *            - foundations 5 css and js librarys
 *            - jquery
 *            - jquery datatables
 *            - datepicker and spanish plug 
 *            - razorflow library charts
 *            - Manage Sessions functions
 *            - php mailer
 *            - and many others litles functions to help you
 ***/


class TinyMVC_Library_Helpers {

  var $app_name;
  var $server_name;
  var $folder_name;
  var $base_url;

  function __construct(){

   /***  set principal routes apps and globals vars class */

   $this->app_name = "Your name app";
   //$this->server_name = $_SERVER['SERVER_NAME'];
   $this->server_name = "192.168.2.123";
   $this->folder_name = "your_folder_app";
   $this->base_url = "http://$this->server_name/$this->folder_name"; // this for work on local host
   //$this->base_url = "http://$this->server_name";                  // this for work on Server

  }


  
  //**************************************************************   Url functions ************************************************************************************




  function to($case,$data){
    switch ($case){
     case 'base_url': return "$this->base_url";
     case 'css' : return "$this->base_url/myapp/views/assets/css/";
     case 'js'  : return "$this->base_url/myapp/views/assets/js/";
    
     //Folders documents
     case 'files':   return "$this->base_url/myapp/files/"; 
     
     //Folder images
     case 'images' : return "$this->base_url/myapp/views/assets/img/";

     //Administrator
     case 'admin'                  : return "$this->base_url/admin";
     case 'home'                   : return "$this->base_url/admin";


     //Users System
     case 'Users'            : return "$this->base_url/Users";
     case 'addUser'          : return "$this->base_url/Users/addUser";
     case 'editUser'         : return "$this->base_url/Users/editUser";
     case 'editPrivileges'   : return "$this->base_url/Users/editPrivileges";
     case 'updateUser'       : return "$this->base_url/Users/updateUser";
     case 'updatePrivileges' : return "$this->base_url/Users/updatePrivileges";
     case 'usersList'        : return "$this->base_url/update_user";
     case 'insertUser'       : return "$this->base_url/Users/insertUser";
     case 'enableUser'       : return "$this->base_url/Users/enableUser";
     case 'disableUser'      : return "$this->base_url/Users/disableUser";

     //Active User account controller
     case 'activate_user_account' : return "$this->base_url/activation_account";
     case 'edit_password'         : return "$this->base_url/update_account";
     
     //login users
     case 'destroy_session'     : return "$this->base_url/login/destroy_session";
     case 'login'               : return "$this->base_url/login";
     case 'recovery_password'   : return "$this->base_url/login/recovery_password";
     case 'renew_password'      : return "$this->base_url/login/renew_password";

     //Main menu (here your menu)
     case 'try' : return "$this->base_url/try";


    }
  }
  
  //Helper url dispatch
  function urldispatch($case,$data=""){
   echo $this->to($case,$data);
  }

  function load_css($case = 'default'){  
    switch($case){ 

    case 'default'    : return "<link rel='stylesheet' href='$this->base_url/myapp/views/assets/css/administracion.css'>\n
                                <link rel='stylesheet' href='$this->base_url/myapp/views/assets/css/font-awesome.min.css'>";

    case 'datatables' : return "<link rel='stylesheet' href='$this->base_url/myapp/views/assets/css/dataTables.foundation.css'>\n
                                <link rel='stylesheet' href='$this->base_url/myapp/views/assets/css/dataTables.tableTools.min.css'>\n
                                <link rel='stylesheet' href='$this->base_url/myapp/views/assets/css/fixedHeader.min.css'>";

    case 'datepicker' : return "<link rel='stylesheet' href='$this->base_url/myapp/views/assets/css/foundation-datepicker.min.css'>";

    case 'razorflow'  : return "<link rel='stylesheet' href='myapp/views/assets/css/razorflow.min.css'>";

   
    }
  
  }
  
  function load_javascript($case = 'default') {
    switch($case){

    case 'header'     : return "<script src='$this->base_url/myapp/views/assets/js/vendor/modernizr.js'></script>";
    case 'footer'     : return "<script src='$this->base_url/myapp/views/assets/js/vendor/jquery.js'></script>\n
                                <script src='$this->base_url/myapp/views/assets/js/foundation.min.js'></script>";

    case 'datatables' : return "<script src='$this->base_url/myapp/views/assets/js/jquery.dataTables.min.js'></script>\n
                                <script src='$this->base_url/myapp/views/assets/js/dataTables.foundation.min.js'></script>\n
                                <script src='$this->base_url/myapp/views/assets/js/fixedHeader.min.js'></script>\n";

    case 'datepicker' : return "<script src='$this->base_url/myapp/views/assets/js/foundation-datepicker.min.js'></script>\n
                                <script src='$this->base_url/myapp/views/assets/js/foundation-datepicker.es.js'></script>";

    case 'razorflow'  : return "<script src='myapp/views/assets/js/razorflow.min.js'></script>\n
                                <script src='myapp/views/assets/js/razorflow.devtools.min.js'></script>";
    
    case 'angularJs'  : return "<script src='http://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js'></script>\n";
    
    }
  }
  



//************************************************************   Session functions **********************************************************************




  function secure_session_start(){
    
    $session_name = 'secure_session';
    $secure = false;
    $httponly = true;
    ini_set("session.cookie_lifetime","7200");
    ini_set("session.gc_maxlifetime","7200");
    ini_set('session.use_only_cookies', 1);       //Forza a las sesiones a sólo utilizar cookies.
    $cookieParams = session_get_cookie_params();  //Obtén params de cookies actuales.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name);                  //Configura el nombre de sesión a el configurado arriba.
    session_start();                              //Inicia la sesión php 
    session_regenerate_id(true);                  //Regenera la sesión, borra la previa.
    
    if(!$_SESSION['login_id']) return false;
    return true; 
  }

  function check_privileges($type,$table_name){
    $home = $this->to(home);
    if(!$_SESSION[privileges][$table_name][$type]){
      Header("Location:$home");
      exit;
    }
  }

  
  
  
  //************************************************ e-mails functions **************************************************************************************




  function php_mailer(){
    require_once('PHPMailer/class.phpmailer.php');
  }

  private function mailer($info=array()){ 
    
    require_once('PHPMailer/class.phpmailer.php');
    
    $mail  = new PHPMailer();
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = false;                  // enable SMTP authentication
    $mail->Host       = "10.10.0.176"; // sets the SMTP server
    $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
    $mail->SetFrom('minutrade@qin.cl');
    $mail->AddReplyTo("no@respon.der");
    $mail->Subject    = $info[subject];
    $mail->AltBody = "Para ver este mensaje, active la vista HTML";
    $mail->Body = $info[email_body];
    $mail->IsHTML(true); 
    $mail->AddAddress($info[email]);
    $mail->charSet = "UTF-8";   
    $mail->Send();


    
    return true;
  
  }

  function send_notification_user($user){
    require('emails_views/send_notification_view.php');
    $info = array('email' => $user[user_login], 'subject' => 'Bienvenido a '.$this->app_name.' Administrador', 'email_body' => $email_body);
    $this->mailer($info);
    return;
  }
  
  function send_recovery_password_email($user){
    require('emails_views/send_recovery_password_view.php');
    $info = array('email' => $user[login], 'subject' => 'Recuperacion de password,'.$this->app_name.'', 'email_body' => $email_body);
    $this->mailer($info);
    return;

   }
  
  function send_new_password_email($user,$password){
    require('emails_views/send_new_password_view.php');
    $info = array('email' => $user[login], 'subject' => 'Tu nuevo password, '.$this->app_name.' Administrador.', 'email_body' => $email_body);
    $this->mailer($info);
    return;
  }
  
  
  

  //************************************************ Others helpers functions **************************************************************************************


  

  function check_extension($name_file, $extensions = array('.jpg', '.pdf', '.doc', '.docx')){
    $ext = $this->get_extencion_file($name_file);
     if(!in_array($ext,$extensions)){
         return false;
      }
      
    return true;
  }

  function get_extencion_file($file_name){
    if(!$file_name) return false;
    $extencion = substr($file_name, strrpos($file_name,'.'));
    return $extencion;
  }

  function clean_spaces($string){
    $clean = preg_replace( "([ ]+)", "", $string);
    return $clean;
  }
    
  function upload_file($file_tmp,$file_name,$folder){
    $file_name = $this->clean_spaces($file_name);

    if(!$dir = opendir($folder)) mkdir($folder,0777);
    $route = $folder.$file_name;
    if(move_uploaded_file($file_tmp, $route)) return true;
    return false;
    
   
  
  }//End function

  


  //Delete directory complete (recursive funcntion)
  function deleteDirectory($dir) {
    if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
          if($current != '.' && $current != '..') {
            if (!@unlink($dir.'/'.$current)) $this->deleteDirectory($dir.'/'.$current);
          }       
        }
    closedir($dh);
    @rmdir($dir);
  }





}//End Class

?>
