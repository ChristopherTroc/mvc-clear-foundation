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
		                              <table border="0" cellpadding="10" cellspacing="0" width="100%" id="emailHeader" style="background-color:#9bb540; color:#FFF;">
		                                  <tr>
		                                      <td align="left" valign="top">
		                                          Tu nuevo password, '.$this->app_name.' Administrador
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
?>
