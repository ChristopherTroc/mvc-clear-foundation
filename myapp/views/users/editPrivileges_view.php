    <div class="row">
        <div class="large-12 columns">
            <div class="white-panel">
                <h5> Editar Privilegios de  <?if($userInfo){?> <?=$userInfo[name]." ".$userInfo[last_name]?>  <? } else {?> <?=$_SESSION[login]?> <?}?>  </h5><hr></hr>
                <form action="<?$helper->urldispatch('updatePrivileges')?>" method="post" data-abide >
                    <div class="row">
                        <div class="columns large-12">
                            <label>Usuarios: </label>
                            <input id="us1" type="checkbox" name="us_view"   <?if($privileges[users][view])  {?> checked <?}?> ><label for="us1">ver</label>
                            <input id="us2" type="checkbox" name="us_edit"   <?if($privileges[users][edit])  {?> checked <?}?> ><label for="us2">editar</label>
                            <input id="us3" type="checkbox" name="us_delete" <?if($privileges[users][delete]){?> checked <?}?> ><label for="us3">deshabilitar/habilitar</label>
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
