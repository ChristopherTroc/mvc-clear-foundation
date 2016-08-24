<?
class Users_Controller extends TinyMVC_Controller {
  
  function __construct(){
    parent::__construct();
    $this->load->library('helpers');
    
    //Access security
    if(!$this->helpers->secure_session_start() OR !$_SESSION[privileges][users][view]) { 
      $home = $this->helpers->to('home');
      Header("Location: $home");
      exit;
     }
  }

  function index(){
    //Alert msg. about insert process.
    if($_GET[success]) $this->view->assign('success', "El proceso ha concluido con exito. EL usuario sera notificado a traves de un e-mail." );
    if($_GET[success] == "switch") $this->view->assign('success', "El proceso ha concluido con exito." );
    if($_GET[alert])   $this->view->assign('alert', "Hubo un error al procesar la información, favor intente nuevamente.");
    if($_GET[exists])  $this->view->assign('alert', "Este Usuario ya existe en la base de datos, favor vreifique esta información.");

    $this->view->assign('stylesheets',   array($this->helpers->load_css(), $this->helpers->load_css('datatables')));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer'),$this->helpers->load_javascript('datatables')));
    
    //Menu link active
    $this->view->assign('active','Users');
    $this->view->assign('title','Lista de Usuarios');
    $this->view->assign('helper',$this->helpers);

    //call models
    $this->load->model("Users_Model","model_users");
    $usersList = $this->model_users->get_users_list();
    $this->view->assign('usersList', $usersList);

    $this->view->display('header');

    //Display dinamic alert
    if($_GET[success]) $this->view->display('success');
    if($_GET[alert])   $this->view->display('alert');
    if($_GET[exists])   $this->view->display('alert');

    $this->view->display('menu');
    $this->view->display('userList_view');
    $this->view->display('footer');
      
    return;
  }
  
  function addUser(){
    //Check privileges
    $this->helpers->check_privileges('edit','users');

    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
      
    
    //Menu link active
    $this->view->assign('active','Users');
    $this->view->assign('title','Agregar Usuario');
    $this->view->assign('helper',$this->helpers);
  

    $this->view->display('header');
    $this->view->display('menu');
    $this->view->display('addUser_view');
    $this->view->display('footer');
      
    return;
  }

  function editUser(){
    //Check privileges
    $this->helpers->check_privileges('edit','users');
    
    if(!$_GET[id]){
      $home = $this->helpers->to('home');
      Header("Location:$home"); exit;
    }

    $this->load->model("Users_Model", "user_model");
    //Get user info
    $userInfo   = $this->user_model->get_user_info_bylogin($_GET[id]);

    //Menu link active
    $this->view->assign('active','Users');
    $this->view->assign('userInfo',$userInfo);
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
      
    
    $this->view->assign('title','Editar Usuario');
    $this->view->assign('helper',$this->helpers);
  

    $this->view->display('header');
    $this->view->display('menu');
    $this->view->display('editUser_view');
    $this->view->display('footer');
      
    return;
  }

  function editPrivileges(){
    //Check privileges
    $this->helpers->check_privileges('edit','users');
    
    if(!$_GET[id]){
      $home = $this->helpers->to('home');
      Header("Location:$home"); exit;
    }

    $this->load->model("Users_Model", "user_model");
    //Get user info
    $userInfo   = $this->user_model->get_user_info_bylogin($_GET[id]);
    //Get privileges user
    $privileges[users]             = $this->user_model->getPrivileges($_GET[id],'users');

    //Menu link active
    $this->view->assign('active','Users');
    $this->view->assign('userInfo',$userInfo);
    $this->view->assign('privileges',$privileges);
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
      
    
    $this->view->assign('title','Editar Permisos de Usuario');
    $this->view->assign('helper',$this->helpers);
  

    $this->view->display('header');
    $this->view->display('menu');
    $this->view->display('editPrivileges_view');
    $this->view->display('footer');
      
    return;
  }


  //Process Functions


  function insertUser(){
    //Check privileges
    $this->helpers->check_privileges('edit','users');

    //Controller url 
    $url = $this->helpers->to('Users');

    $userInfo = array('name'      => $_POST[name],
                      'last_name' => $_POST[last_name],
                      'email'     => $_POST[email]
                     );

    $userPrivileges = array('users' => array('view' => $_POST[us_view], 'edit' => $_POST[us_edit], 'delete' => $_POST[us_delete]));

    //call models
    $this->load->model("Users_Model","model_users");
    
    //make a user on database
    $user = $this->model_users->new_user($userInfo[email],$level=1);
    
    //if user already exists on database
    if($user == 'already_exists'): Header("Location:$url?exists=true"); exit; endif;
  
    //create array with new user information
    $user_array = array( 'id_login'     => $user[id],
                         'name'         => $userInfo[name],
                         'last_name'    => $userInfo[last_name],
                         'email'        => $userInfo[email] );
    

    //Insert user info to database
    $this->model_users->insert_user_info($user_array);

    //Insert user privileges
    $this->model_users->insert_user_privileges($user[id],$userPrivileges);

    //notificate administrator email, (Use Php mailer)
    $this->helpers->send_notification_user($user);

    //Success notification 
    Header("Location:$url?success=true");

    return;

  }
  
  function updateUser(){
    //Check privileges
    $this->helpers->check_privileges('edit','users');

    if(!$_POST[id]){
      $home = $this->helpers->to('home');
      Header("Location:$home"); exit;
    }

    //Controller url 
    $url = $this->helpers->to('Users');

    //call models
    $this->load->model("Users_Model","model_users");

    $userCurrent  = $this->model_users->get_user_info_bylogin($_POST[id]);

    $userInfo = array('id_login'  => $_POST[id],
                      'name'      => $_POST[name],
                      'last_name' => $_POST[last_name],
                      'email'     => $_POST[email],
                      'password'  => $_POST[password]
                     );


    //Update Logic Process
    $url = $this->helpers->to('Users');
    

    if($userCurrent[email] != $userInfo[email]){
       $update_account    = $this->model_users->update_email_account($userInfo);
       $update_userInfo   = $this->model_users->update_user_info($userInfo);
    
       if($update_account AND $update_userInfo){ 
          $userNotification = array('id'    => $_POST[id],
                                    'user_login' => $userInfo[email],
                                    'pass'       => $userInfo[password],
                                    'key'        => $update_account);
 
          $this->helpers->send_notification_user($userNotification);
          Header("Location:$url?success=true"); exit;
       }
       
       Header("Location:$url?alert=true_step_1"); exit;

    } else {

      $update_userInfo   = $this->model_users->update_user_info($userInfo);
      $update_password   = $this->model_users->update_password($userInfo[password],$userInfo[id_login]);

      if($update_userInfo AND $update_password){

         $userNotification = array('login' => $userInfo[email]);
         $this->helpers->send_new_password_email($userNotification,$userInfo[password]);
         Header("Location:$url?success=true"); exit;
      }
      
      Header("Location:$url?alert=true_step_2"); exit;
    }

    

    //Alert notification 
    Header("Location:$url?alert=true_step_3");
    return false;

  }

  function updatePrivileges(){
   
    //Check privileges
    $this->helpers->check_privileges('edit','users');

    if(!$_POST[id]){
      $home = $this->helpers->to('home');
      Header("Location:$home"); exit;
    }


    $userPrivileges = array('users' => array('view' => $_POST[us_view], 'edit' => $_POST[us_edit], 'delete' => $_POST[us_delete]));


    //Update Logic Process
    $this->load->model("Users_Model","model_users");
    $update_privileges = $this->model_users->update_user_privileges($_POST[id],$userPrivileges);
    
    //Notifications
    //Controller url 
    $url = $this->helpers->to('Users');

    if($update_privileges){
      Header("Location:$url?success=switch");
      return true;
    }

      Header("Location:$url?alert=true");
      return false;

  } 

  function disableUser(){
    //Check privileges
    $this->helpers->check_privileges('delete','users');

    if(!$_GET[id]){
      $home = $this->helpers->to('home');
      Header("Location:$home");
      exit;
      }

    $this->load->model("Users_Model", "model_users");
    $execute = $this->model_users->disableUser($_GET[id]);

    $url = $this->helpers->to('Users');

    if($execute){
      Header("Location:$url?success=switch");
      exit;
    } else {
      Header("Location:$url?alert=true");
      exit;
    }

    

  }

  function enableUser(){
    //Check privileges
    $this->helpers->check_privileges('delete','users');

    if(!$_GET[id]){
      $home = $this->helpers->to('home');
      Header("Location:$home");
      exit;
    }
  
    $this->load->model("Users_Model","model_users");
    $execute = $this->model_users->enableUser($_GET[id]);

    $url = $this->helpers->to('Users');

    if($execute){
      Header("Location:$url?success=switch");
      exit;
    } else {
      Header("Location:$url?alert=true");
      exit;
    }

  }


}//End class
?>
