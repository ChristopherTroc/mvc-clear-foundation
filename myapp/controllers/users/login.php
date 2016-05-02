<? 
class Login_Controller extends TinyMVC_Controller {
  
  function index(){
    if($_POST['user'] AND $_POST['pass']):
      $verify = $this->verify_login($_POST['user'],$_POST['pass']);
      if($verify):
        header('Location:'.$this->helpers->to('admin')); 
      else:
        $this->error_pass();
      endif;
    else:
      $this->fields_empty();
    endif;
}

//************************************************  Logic functions ***************************************************



  function verify_login($user='',$pass=''){

    $this->load->model('Users_Model','users');
    $user_valid = $this->users->verify_login($user,$pass);

    if($user_valid){
      //Check if user active on system
      if(!$this->is_user_active($user_valid)):
        $this->no_active();
        exit;
      endif;

      //Check if user disabled on system
      if(!$this->is_user_disabled($user_valid)):
        $this->disabled();
        exit;
      endif;

      //Start session
      $this->helpers->secure_session_start();
      $_SESSION['login_id']   = $user_valid['id'];
      $_SESSION['user_level'] = $user_valid['user_level'];
      $_SESSION['user_login'] = $user_valid['login'];
      $_SESSION['state']      = $user_valid['active'];

      //Get previleges by table of user
      //$_SESSION[privileges][time_restrictions] = $this->users->getPrivileges($user_valid[id],'time_restrictions');
      $_SESSION[privileges][users]             = $this->users->getPrivileges($user_valid[id],'users');

      //Get User Info
      $_SESSION[userInfo] = $this->users->get_user_info_bylogin($user_valid[id]);

      return true;

    } else {

    //log fail login (display disable view if return true)
    $ip_request = $_SERVER[REMOTE_ADDR];
    $disable = $this->users->log_fail_login($user,$ip_request);
    if($disable){ $this->disabled(); exit; }

    return false;

    }
     
  }//End function

  function is_user_active($user){
    if(!$user['active']) return false;
    return true;
  }

  function is_user_disabled($user){
    if($user[active] == 2) return false;
    return true;
  }
  
  function recovery_password(){
    
    $email_user = $_GET[email];
    
    if(!$email_user) return false;
    //Check email
    $this->load->model('Users_Model','users'); 
    $user = $this->users->verify_email($email_user);
    
    if($user){
      $this->users->renew_activation_key($user[id]);
      $user = $this->users->verify_email($email_user);
      $this->helpers->send_recovery_password_email($user);
      usleep(250000);
      echo "1";
    } else {
      echo "2"; 
      usleep(250000);
    }

  
  }

  function renew_password(){
    $home = $this->helpers->to('home');

    $id_user = $_GET[id];
    $key = $_GET[key];
  
    if(!$key OR !$id_user):  Header("Location:$home"); exit; endif;
    
    $this->load->model('Users_Model','users');
    $user = $this->users->get_user($id_user);
  
    if($user[activation_key] == $key):
     $password = substr( md5(microtime()), 1, 6);
     $renew = $this->users->update_password($password,$user[id]);
     $act_key = $this->users->renew_activation_key($user[id]);
     if($renew AND $act_key): $this->helpers->send_new_password_email($user,$password); endif;
    else:
     Header("Location:$home"); exit;
    endif;
    

 
    Header("Location:$home?success=renew_password");
    return true;

  }

  function destroy_session(){
    // Start secure session
    $this->helpers->secure_session_start();
    //Clean values of session
    $_SESSION = array();
    // Obtain params
    $params = session_get_cookie_params();
    // Delete current cookie 
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    // Destroy sessión
    session_destroy();
    //redirect to home
    header('Location:'.$this->helpers->to('home'));
    
  }


  function clean_session(){
    // Start secure session
    $this->helpers->secure_session_start();
    //Clean values of session
    $_SESSION = array();
    // Obtain params
    $params = session_get_cookie_params();
    // Delete current cookie 
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    // Destroy sessión
    session_destroy();
    
  }

  //*******************************   Function Load diferent view and alerts  ***********************************************




  function fields_empty() {
    
    $this->view->assign('alert','Debes llenar los dos campos solicitados.');
    $this->view->assign('helper', $this->helpers);
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
    $this->view->display('header');
    $this->view->display('alert');
    $this->view->display('login_view');
    $this->view->display('footer');      
  }

  function error_pass(){

    global $dr; 
    $this->view->assign('dr', $dr);
    $this->view->assign('alert','Usuario, o password incorrectos.');
    $this->view->assign('helper', $this->helpers);
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
    $this->view->display('header');
    $this->view->display('alert');
    $this->view->display('login_view');
    $this->view->display('footer');      
  }
  
  function no_active(){
  
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
    $this->view->assign('alert','Este usuario no esta activo en el sistema, ingrese a su email y active su usuario.');
    $this->view->assign('helper', $this->helpers);
    $this->view->display('header');
    $this->view->display('alert');
    $this->view->display('login_view');
    $this->view->display('footer');      
  }

  function disabled(){
  
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
    $this->view->assign('alert','Este usuario ha sido deshabilitado para hacer uso del sistema.');
    $this->view->assign('helper', $this->helpers);
    $this->view->display('header');
    $this->view->display('alert');
    $this->view->display('login_view');
    $this->view->display('footer');      
  }





}  //End class  controller
?>
