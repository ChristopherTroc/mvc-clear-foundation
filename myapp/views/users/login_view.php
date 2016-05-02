    <div class="spacer-20"></div>
    <div class="row">
        <div class="large-12 columns">
            <div class="white-panel-25 radius">
                <div class="spacer-25"></div>
                <div class="row">
                    <div class="large-4 large-offset-1 columns text-center">
                    <img src='<?=$helper->urldispatch('images')?>logo-movistar-under.jpg' alt="Movistar" />
                    </div>
                    <div class="large-5 large-offset-1 end columns">
                        <div class="row">
                            <div class="large-12 columns">
                                <h4>Minutrade Portal de Administración</h4>
                                <a href="#" data-reveal-id="forget-password" class="large-offset-6" >¿olvido su password?</a>
                                <form method="post" action="<?$helper->urldispatch('login')?>" data-abide >
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <label for="id_username">Usuario
                                                <input type="text" name="user" id="id_username" required  />
                                                <small class="error" data-error-message="" > Favor ingresar nombre usuario </small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <label for="id_password">Contraseña
                                                <input type="password" name="pass" id="id_password" required />
                                                <small class="error" data-error-message="" > Favor ingresar contraseña </small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="large-4 large-offset-8 columns">
                                            <input type="submit" class="button small expand radius" value="Iniciar sesión">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div id="forget-password" class="reveal-modal radius small" data-reveal aria-labelledby="password-recovery" aria-hidden="true" role="dialog">
        <h4>Recupera tu password</h4><hr>
        <p>Para recuperar tu password, ingresa tu e-mail de usuario.</p>
        <div id="ajax_response"></div>
        <form  role="form"  >
            <input type="text" name="user_email" id="user_email"  placeholder="tu@email.com" />
            <button type="button" class="button small radius" id="send-recovery">Enviar</button>
        </form>
      <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>



    </div> <!-- End Wrap -->

    <!-- Load footer JS librarys -->
    <?foreach($javascripts_ft AS $load_script):?>
    <?=$load_script?>
    <?endforeach;?>

    <script>
   $(document).foundation('reflow');

   $(document).ready(function(){
     //Recovery pass ajax process
     $("#send-recovery").click(function(){

       if($("#user_email").val() == ""){ $("#user_email").focus(); return false; }

       var url= "<?$helper->urldispatch('recovery_password')?>";
       var datastring = "email="+$("#user_email").val();
       $("#ajax_response").html("<div class='large-2 large-offset-5' style='padding:5px'><img src='<? $helper->urldispatch('images'); ?>loading.gif' /></div>");
       
       $.ajax({
          type:    "GET",
          url:     url,
          data:    datastring,
          success: function(data){
            
            //uncomment for debug 
            //$("#ajax_response").fadeIn(1000).html(data);
  
              if(data == 1){
              html = "<div class='success alert-box'>Revice su casilla de correo, Se han enviado las intrucciones para la recuperación de su password.<div>";
              $("#ajax_response").fadeIn(1000).html(html);
              return;
             }

            if(data == 2){
              html = "<div class='alert alert-box'>El email ingresado, no se encuentra en los registros del sistema. Chequee la información ingresada.<p>";
              $("#ajax_response").fadeIn(1000).html(html);
              return;
            }
            
            
          }
        
       });
     });

    }); //End Ready
    </script> 





