    <div class="row">
        <div class="large-12 columns">
            <div class="white-panel">
                <h5>Editar Usuario administrador minutrade </h5><hr>
                <form action="<?$helper->urldispatch('updateUser')?>" method="post" data-abide >
                    <div class="row">
                        <div class="columns large-12">
                            <label for="name">nombre
                                <span class="asterisk">*</span>
                            </label>
                            <input id="name" maxlength="50" name="name" value="<?=$userInfo[name]?>" type="text" required  >
                            <small class="error" data-error-message="" > favor ingresar un nombre </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="last_name" >apellidos
                                <span class="asterisk">*</span>
                            </label>
                            <input id="last_name" maxlength="200" name="last_name" value="<?=$userInfo[last_name]?>" type="text" required>
                            <small class="error" data-error-message="" > favor ingresar apellidos  </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="email" >e-mail
                                <span class="asterisk">*</span>
                            </label>
                            <input id="email" maxlength="200" name="email" value="<?=$userInfo[email]?>" type="text" required  patterns="email">
                            <small class="error" data-error-message="" > favor ingresar un e-mail valido  </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="email-confirm" >confirme e-mail
                                <span class="asterisk">*</span>
                            </label>
                            <input  maxlength="200"  type="text" value="<?=$userInfo[email]?>" required data-equalto="email">
                            <small class="error" data-error-message="" > el e-mail no es igual al ingresado anteriormente.  </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="password" >Password
                                <span class="asterisk">*</span>
                            </label>
                            <input id="password" maxlength="200" name="password" type="password" required pattern="alpha_numeric" placeholder="nuevo password">
                            <small class="error" data-error-message="" > favor ingresar un password alfanumerico de un minimo de 6 caracteres. </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="password-confirm" >confirme password
                                <span class="asterisk">*</span>
                            </label>
                            <input  maxlength="200"  type="password" required data-equalto="password" placeholder="confirme password">
                            <small class="error" data-error-message="" > el password no es igual al ingresado anteriormente.  </small>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$userInfo[id_login]?>">
                    <div class="row">
                        <div class="columns large-2 large-offset-10">
                                <input type="submit" value="Actualizar" id="submit-btn" class="submit button small" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div> <!-- end wrap -->

    <!-- load footer js librarys -->
    <?foreach($javascripts_ft as $load_script):?>
    <?=$load_script?>
    <?endforeach;?>

    <script>
      $(document).foundation();
    </script>


