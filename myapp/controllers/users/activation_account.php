<?
class Activation_account_Controller extends TinyMVC_Controller{


  //Display functions  


  function index(){

    $id_user              =  $_GET[id];
    $activation_key       =  $_GET['key'];

    if(!$id_user OR !$activation_key):
      $url = $this->helpers->to('home'); 
      header('Location:'.$url);
      exit; 
    endif; 

    $this->view->assign('user', array("id_user" => $id_user, "activation_key" => $activation_key));
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
    $this->view->assign('helper', $this->helpers);
    $this->view->display('header');
    $this->view->display('conditions_view');
    $this->view->display('footer');      

  }



  function actived(){
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
    $this->view->assign('success','Tu Cuenta de usuario ha sido activada.');
    $this->view->assign('helper', $this->helpers);
    $this->view->display('header');
    $this->view->display('success');
    $this->view->display('login_view');
    $this->view->display('footer');      
  }


  //Process functions 


  function acept_conditions(){
    $id_user              =  $_POST[id_user];
    $activation_key       =  $_POST[activation_key];

    $this->activate_process($id_user, $activation_key);
  }

  private function activate_process($id_user,$activation_key){

    $this->load->model('Users_Model','users');
    $key = $this->users->get_activation_key($id_user);
    
    if(!$id_user OR !$activation_key OR $activation_key != $key[activation_key]):
      $url = $this->helpers->to('home'); 
      header('Location:'.$url);
      exit; 
    endif;
      
    $active = $this->users->active_account($id_user);

    if($active) $this->actived();
    
  }


} //End class controller
?>
