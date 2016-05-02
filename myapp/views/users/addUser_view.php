    <div class="row">
        <div class="large-12 columns">
            <div class="white-panel">
                <h5>Añadir nuevo usuario Administrador Minutrade </h5><hr>
                <form action="<?$helper->urldispatch('insertUser')?>" method="post" data-abide >
                    <div class="row">
                        <div class="columns large-12">
                            <label for="name">Nombre
                                <span class="asterisk">*</span>
                            </label>
                            <input id="name" maxlength="50" name="name" type="text" required  >
                            <small class="error" data-error-message="" > Favor ingresar un Nombre </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="last_name" >Apellidos
                                <span class="asterisk">*</span>
                            </label>
                            <input id="last_name" maxlength="200" name="last_name" type="text" required>
                            <small class="error" data-error-message="" > Favor ingresar Apellidos  </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="email" >E-mail
                                <span class="asterisk">*</span>
                            </label>
                            <input id="email" maxlength="200" name="email" type="text" required  patterns="email">
                            <small class="error" data-error-message="" > Favor ingresar un e-mail valido  </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-12">
                            <label for="email-confirm" >Confirme E-mail
                                <span class="asterisk">*</span>
                            </label>
                            <input  maxlength="200"  type="text" required data-equalto="email">
                            <small class="error" data-error-message="" > El e-mail no es igual al ingresado anteriormente.  </small>
                        </div>
                    </div>
                    <h5>Permisos de Usuario</h5><hr>
                    <div class="row">
                        <div class="columns large-12">
                            <label>Usuarios: </label>
                            <input id="us1" type="checkbox" name="us_view" ><label for="us1">Ver</label>
                            <input id="us2" type="checkbox" name="us_edit" ><label for="us2">Editar</label>
                            <input id="us3" type="checkbox" name="us_delete" ><label for="us3">Deshabilitar/Habilitar</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-2 large-offset-10">
                                <input type="submit" value="Ingresar" id="submit-btn" class="submit button small" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div> <!-- End Wrap -->

    <!-- Load footer JS librarys -->
    <?foreach($javascripts_ft AS $load_script):?>
    <?=$load_script?>
    <?endforeach;?>

    <script>
      $(document).foundation();
    </script>





