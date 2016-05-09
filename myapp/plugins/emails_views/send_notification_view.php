<?php
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
		                                          Bienvenido a '.$this->app_name.'
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
?>
