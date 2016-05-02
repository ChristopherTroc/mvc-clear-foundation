<?
class Admin_Controller extends TinyMVC_Controller {
  
  function index() {


     //echo "<h4>Sistema en actualizacion. !!! volvemos en 30 minutos.</h4> ";
     //exit;
    
    $this->helpers->secure_session_start();
    
    if($_SESSION['login_id']) { //if session start

      //Redirect to another controller (your controller)
      $home = $this->helpers->to('your_controller');
      Header("Location:$home"); exit;
      
    }
    

    $this->view->assign('success',"Password actualizado. Hemos enviado tu nuevo password a tu casilla de correo.");
    $this->view->assign('stylesheets',   array($this->helpers->load_css()));
    $this->view->assign('javascripts',   array($this->helpers->load_javascript('header')));
    $this->view->assign('javascripts_ft',array($this->helpers->load_javascript('footer')));
    $this->view->assign('title','Minutrade Movistar');
    $this->view->assign('helper',$this->helpers);
    $this->view->display('header');
    if($_GET[success]) $this->view->display('success');
    $this->view->display('login_view');
    $this->view->display('footer');
  
  }


  
}
?>
