<?php
class Try_Controller extends TinyMVC_Controller{
   function index(){
    echo "This is Try example controller, default  function index()";
    $this->helpers->secure_session_start();
    if($_SESSION['login_id']){
      echo "Your Login ON";
      echo "<br/><a href='".$this->helpers->to(destroy_session)."'> Cerrar sesion </a>"; 
    } else {
      echo "Your Login OFF";
    }
  }
}
?>
