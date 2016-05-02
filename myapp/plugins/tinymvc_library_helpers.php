<?

/***
 * Name: Helpers
 * Owner: C-troc
 * Description: This plugins have a lot of tools to manage app
 * Modules:   - url_dispatcher
 *            - foundations 5 css and js librarys
 *            - jquery
 *            - jquery datatables
 *            - datepicker and spanish plug 
 *            - razorflow library charts
 *            - Manage Sessions functions
 *            - php mailer
 *            - and many anotheers litles functions to help you
 ***/

class TinyMVC_Library_Helpers {

  var $server_name;
  var $folder_name;
  var $base_url;

  function __construct(){
 
   /***  set principal routes apps and globals vars class */

   $this->name_app = "Your name app";
   //$this->server_name = $_SERVER['SERVER_NAME'];
   $this->server_name = "192.168.2.123";
   $this->folder_name = "minutrade";
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

    $email_body='
      <!DOCTYPE html>
          <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head>
          <body style="font-family: Helvetica, Arial, Sans-Serif;">
	        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
	            <tr>
		              <td align="left" valign="top">
		                  <table border="0" cellpadding="20" cellspacing="0" width="720" id="emailContainer">
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="10" cellspacing="0" width="100%" style="background-color:#9bb540; color:#FFF;">
		                                  <tr>
		                                      <td align="left" valign="top">
		                                          Bienvenido a '.$this->name_app.'
		                                      </td>
		                                  </tr>
		                              </table>
		                          </td>
		                      </tr>
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="0" cellspacing="0" width="70%" id="emailBody">
		                                  <tr>
		                                      <td align="left" valign="top">
		                                          Nombre de usuario:
		                                      </td>
                                          <td align="left" valign="top" style="background-color:#9bb540; color:#FFF; padding:2px;">
		                                          '.$user[user_login].'
		                                      </td>
		                                  </tr>
                                      <tr>
		                                      <td align="left" valign="top">
		                                          Password:
		                                      </td>
                                          <td align="left" valign="top" style="background-color:#9bb540; color:#FFF; padding:2px;">
		                                          '.$user[pass].'
		                                      </td>
		                                  </tr>
		                              </table>
		                          </td>
		                      </tr>
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailFooter">
		                                  <tr>
		                                      <td align="left" valign="top">
		                                          Para poder hacer uso del sistema, debes activar tu Cuenta de usuario haciendo click en el siguiente link:
                                              <a href="'.$this->to('activate_user_account').'?id='.$user[id].'&key='.$user['key'].'"><strong>Activar Cuenta de Usuario</strong></a>
		                                      </td>
		                                  </tr>
		                              </table>
		                          </td>
		                      </tr>
		                  </table>
		              </td>
	            </tr>
	        </table>
       </body>
    </html>';
    

    $info = array('email' => $user[user_login], 'subject' => 'Bienvenido a '.$this->name_app.' Administrador', 'email_body' => $email_body);
    $this->mailer($info);
    return;
  }
  
  function send_recovery_password_email($user){
    $email_body='
      <!DOCTYPE html>
          <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head>
          <body style="font-family: Helvetica, Arial, Sans-Serif;">
	        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
	            <tr>
		              <td align="left" valign="top">
		                  <table border="0" cellpadding="20" cellspacing="0" width="720" id="emailContainer">
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="10" cellspacing="0" width="100%" id="emailHeader" style="background-color:#9bb540; color:#FFF;">
		                                  <tr>
		                                      <td align="left" valign="top">
		                                          Recuperación de password, '.$this->name_app.' Administrador
		                                      </td>
		                                  </tr>
		                              </table>
		                          </td>
		                      </tr>
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailBody">
		                                  <tr>
		                                      <td align="left" valign="top">
                                              Has solicitado recuperar tu password de usuario, has click en el siguiente enlace: </br>
                                              <a href="'.$this->to('renew_password').'?id='.$user[id].'&key='.$user[activation_key].'"><strong>Recuperar Password</strong></a>
                                          </td>
                                      </tr>
		                              </table>
		                          </td>
		                      </tr>
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailFooter">
		                                  <tr>
                                          <td align="left" valign="top">
                                              En caso que no hallas solicitado la recuperación de password, omita este email. y notifique esta situación a <a href="mailto:ctroc@qin.cl" >ctroc@qin.cl</a>
		                                      </td>
		                                  </tr>
		                              </table>
		                          </td>
		                      </tr>
		                  </table>
		              </td>
	            </tr>
	        </table>
       </body>
    </html>';

    $info = array('email' => $user[login], 'subject' => 'Recuperacion de password, Minutrade Administrador.', 'email_body' => $email_body);
    $this->mailer($info);
    return;

   }
  
  function send_new_password_email($user,$password){
    $email_body='
      <!DOCTYPE html>
          <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head>
          <body style="font-family: Helvetica, Arial, Sans-Serif;">
	        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
	            <tr>
		              <td align="left" valign="top">
		                  <table border="0" cellpadding="20" cellspacing="0" width="720" id="emailContainer">
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="10" cellspacing="0" width="100%" id="emailHeader" style="background-color:#9bb540; color:#FFF;">
		                                  <tr>
		                                      <td align="left" valign="top">
		                                          Tu nuevo password, '.$this->name_app.' Administrador
		                                      </td>
		                                  </tr>
		                              </table>
		                          </td>
		                      </tr>
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailBody">
		                                  <tr>
                                          <td align="left" valign="top">
                                              Has recuperado tu password, tu nuevo password es: <span style="background-color:#9bb540; color:#FFF; padding:2px;">'.$password.'</span>
                                          </td>
                                      </tr>
		                              </table>
		                          </td>
		                      </tr>
		                      <tr>
		                          <td align="left" valign="top">
		                              <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailFooter">
		                                  <tr>
                                          <td align="left" valign="top">
                                              <a href="'.$this->to('home').'"><strong>Iniciar Sesión</strong></a>
		                                      </td>
		                                  </tr>
		                              </table>
		                          </td>
		                      </tr>
		                  </table>
		              </td>
	            </tr>
	        </table>
       </body>
    </html>';
     

    $info = array('email' => $user[login], 'subject' => 'Tu nuevo password, '.$this->name_app.' Administrador.', 'email_body' => $email_body);
    $this->mailer($info);
    return;

  
  }


  function check_extension($name_file, $extensions = array('.jpg', '.pdf', '.doc', '.docx')){
    $ext = $this->get_extencion_file($name_file);
     if(!in_array($ext,$extensions)){
         echo "Here"; exit;
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
    $clean = ereg_replace( "([ ]+)", "", $string );
    return $clean;
  }
    
  function upload_file($file_tmp,$file_name,$folder){
    $file_name = $this->clean_spaces($file_name);

    if(!$dir = opendir($folder)) mkdir($folder,0777);
    $route = $folder.$file_name;
    if(move_uploaded_file($file_tmp, $route)) return true;
    return false;
    
   
  
  }//End function

  


  //Deslete directory complete (recursive funcntion)
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
