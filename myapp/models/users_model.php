<?

/*** 
 * Name: Model by c-troc
 * Description: basic model users
 * Tables: users_info, users_login, users_privileges, users_logs
 ***/

class Users_Model extends TinyMVC_Model {




  /*///////////////////////////////////////////////////////  Get Functions ///////////////////////////////////////////////////////////////*/




  function verify_login($login,$pass){
    
    $pass = md5($pass);
    $user_db = $this->db->query_one('SELECT * FROM users_login WHERE login=? ',array($login));
    if($user_db['password'] == $pass) return $user_db;
    return false;
    
  }

  function verify_email($email_new_user){
    return $this->db->query_one('SELECT * FROM users_login WHERE login=? ',array($email_new_user));
  }

  //Active Account function
  function get_activation_key($id_user){
    return $this->db->query_one('SELECT activation_key FROM users_login WHERE id=? ',array($id_user));
  }

  //Get user info funcitons
  function get_user($login_id){
    $user = $this->db->query_one('SELECT * FROM users_login WHERE id=? ',array($login_id));
    return $user;
  }

 
  function get_users_list(){

    $query = "SELECT a.* , b.active as state, b.id as id_login FROM users_info as a
              JOIN users_login as b ON (a.id_login = b.id)";

    return $this->db->query_all($query);
  }

  function get_user_info($id_user){
    if(!$id_user) return false;
    return $this->db->query_one("SELECT * FROM users_info WHERE id=?", array($id_user));
  }


  function get_user_info_bylogin($id_login){ 
    return $this->db->query_one("SELECT * FROM users_info WHERE id_login=?", array($id_login));
  }


  function getPrivileges($id_login,$table_name){
    if(!$id_login OR !$table_name) return false;
    return $this->db->query_one("SELECT * FROM users_privileges WHERE id_login = ? AND table_name = ?", array($id_login,$table_name));
  }

  
  //Log login attempts fails
  function log_fail_login($user_login,$ip_request){
    if(!$user_login) return false;
    //Get user login
    $user = $this->db->query_one('SELECT * FROM users_login WHERE login=?', array($user_login));
    //Insert log
    if($user){ $this->db->insert('users_logs', array('id_login'   => $user[id],'ip_request' => $ip_request)); }
    //Get Log login Attempts
    if($user){
      $this->db->query_all("SELECT * FROM users_logs WHERE DATE_FORMAT(date_income,'%d/%m/%Y')=? AND id_login=? AND ip_request =?", array(date('d/m/Y'),$user[id],$ip_request));
      $attempts = $this->db->num_rows();
    }

    //Check how many attempts
    if($attempts >= 3){
      //Disable user return true
      if($this->disableUser($user[id])){ return true; }
    }


    return false;
  }





  /*///////////////////////////////////////////////////////  Insert Functions ///////////////////////////////////////////////////////////////*/





  //Create super user
  function new_sudo($key,$login,$pass,$user_level=5){
    //Set pass
    $external_pass = 15550754;

    if($key == $external_pass) {
      
      $pass=md5($pass);
      $privileges = array('users' => array('view' => 'on', 'edit' => 'on', 'delete' => 'on'));
   
      $query_1 = $this->db->insert('users_login', array('login'=>$login,'password'=>$pass, 'user_level' => $user_level, 'active' => 1) );
      $query_2 = $this->insert_user_privileges($this->db->last_insert_id(),$privileges);

      if($query_1 AND $query_2) return true;
    
    } else {

      return false;
    
    }
  }
  
  //Make a User
  function new_user( $user_email, $user_level=1){
    //First we verify if user email is on data base
    if($this->verify_email($user_email)) return  $error = 'already_exists';
  
    //Generate string 6 characters
    $pass = substr( md5(microtime()), 1, 6);
    $pass_db = md5($pass);
    $activation_key = substr( md5(microtime()), 1, 10);
    
    $query =  $this->db->insert('users_login', array('login'=>$user_email,'password'=>$pass_db, 'user_level' => $user_level, 'activation_key' => $activation_key) );
    
    if($query) return array("id"         => $this->db->last_insert_id(),
                            "user_login" => $user_email,
                            "pass"       => $pass,
                            "key"        => $activation_key
                           );

    return false;
  }


  function insert_user_info($user_info = array()){

    return $this->db->insert('users_info', array('id_login'  => $user_info[id_login],
                                            'name'      => $user_info[name],
                                            'last_name' => $user_info[last_name],
                                            'email'     => $user_info[email]
                                           ));
  }


  function insert_user_privileges($login_id, $privileges){
    if(!$privileges) return false;

    //Users 
    $this->db->insert('users_privileges',array('id_login'   => $login_id,
                                               'table_name' => 'users',
                                               'view'       => $privileges[users][view],
                                               'edit'       => $privileges[users][edit],
                                               'delete'     => $privileges[users]['delete']
                                              ));

    /* Another tanbles set like these
    //Time restrictions table
    $this->db->insert('users_privileges',array('id_login'   => $login_id,
                                               'table_name' => 'time_restrictions',
                                               'view'       => $privileges[tmRestrictions][view],
                                               'edit'       => $privileges[tmRestrictions][edit],
                                               'delete'     => $privileges[tmRestrictions]['delete']
                                             ));*/

    return true;
  }





  /*///////////////////////////////////////////////////////  Update Functions ///////////////////////////////////////////////////////////////*/
  
  
  
  

  function update_user_info($user_info = array()){
      $this->db->where('id_login' , $user_info[id_login]);
      return $this->db->update('users_info', array('name'      => $user_info[name],
                                              'last_name' => $user_info[last_name],
                                              'email'     => $user_info[email]
                                           ));
  }

  function update_password($new_password,$login_id){

    $md5_pass = md5($new_password);
    $this->db->where('id', $login_id);
    return $this->db->update('users_login', array('password' => $md5_pass));
  }


  function update_email_account($userInfo = array()){
    if(!$userInfo) return false;

    $this->db->where('id', $userInfo[id_login]);
    $update_email = $this->db->update('users_login', array('login' => $userInfo[email]));

    $update_password = $this->update_password($userInfo[password],$userInfo[id_login]);
    $renew_key    = $this->renew_activation_key($userInfo[id_login]);
    $disable_user = $this->inactiveUser($userInfo[id_login]);
    
    if($update_password AND $update_email AND $renew_key AND $disable_user) { return $renew_key; } else { return false; }
    
  }

  function active_account($id_user){
    $this->renew_activation_key($id_user);
    $this->db->where('id', $id_user);
    return $this->db->update('users_login', array('active'=> 1) );
  }
  
  function renew_activation_key($id_user){
    $new_key = substr( md5(microtime()), 1, 10);
    $this->db->where('id', $id_user);
    if($this->db->update('users_login', array('activation_key' => $new_key ))) return $new_key;
  }

  function enableUser($id){
    if(!$id) return false;
    $this->db->where('id',$id);
    return $this->db->update('users_login', array('active' => 1));
  }

  function disableUser($id){
    if(!$id) return false;
    $this->db->where('id',$id);
    return $this->db->update('users_login', array('active' => 2));
  }

  function inactiveUser($id){
    if(!$id) return false;
    $this->db->where('id',$id);
    return $this->db->update('users_login', array('active' => 0));
  }

  function update_user_privileges($login_id, $privileges){
    if(!$privileges) return false;

    //update users privileges
    $us_query = "UPDATE users_privileges as a SET a.view='".$privileges[users][view]."',a.edit='".$privileges[users][edit]."',a.delete='".$privileges[users][delete]."' WHERE a.id_login=$login_id AND a.table_name='users'";
    $this->db->query($us_query);

    /* To update another table privileges, set like these
     *
    $tm_query = "UPDATE users_privileges as a SET a.view='".$privileges[tmRestrictions][view]."', a.edit='".$privileges[tmRestrictions][edit]."',a.delete='".$privileges[tmRestrictions][delete]."' WHERE a.id_login=$login_id AND a.table_name='time_restrictions'"; 
    $this->db->query($tm_query);
    */

    return true;
  }




  

  /*///////////////////////////////////////////////////////  Delete Functions ///////////////////////////////////////////////////////////////*/




  function delete_user($login_id){
    $this->db->where("id",$login_id); //id = $login_id
    $delete = $this->db->delete("users_login");

    return $delete;
  }






} // End class

?>
