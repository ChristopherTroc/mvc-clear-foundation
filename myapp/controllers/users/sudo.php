<?
class Sudo_Controller extends TinyMVC_Controller {
  
  function index(){
    
    Header('Location: ./home');
  }

  function sudo() {
    
    $key = $_GET['key']; $login = $_GET['login']; $pass = $_GET['pass'];
    
    $this->load->model('Users_Model','users');
    $call_back = $this->users->new_sudo($key,$login,$pass);
    
    if($call_back) { echo "sudo creado con exito !!!"; } else { echo "false !!!"; }
  }
}
?>
