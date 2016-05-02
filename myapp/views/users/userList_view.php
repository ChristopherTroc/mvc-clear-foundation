    <div class="row">
        <div class="large-12 columns">
            <div class="white-panel">
                <h5>Lsita de Usuarios Minutrade</h5><hr>
                <table id="tabla" class="dataTable" >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>E-mail</th>
                            <th>Estado</th>
                            <th>Ingreso</th>
                            <th data-orderable="false">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?foreach($usersList AS $list):?>
                        <tr>
                            <td><?=$list[name]?></td>
                            <td><?=$list[last_name]?></td>
                            <td><?=$list[email]?></td>
                            <td><?if($list[state] == 1){?><span class="label success"> Habilitado </span> <?}?>
                                <?if($list[state] == 2){?> <span class="label secondary">Deshabilitado </span> <?}?>
                                <?if($list[state] == 0){?> <span class="label secondary">Pendiente de activación</span><?}?>
                            </td>
                            <td><?=$list[date_income]?></td>
                            <td>
                                <?if($_SESSION[privileges][users][edit]){?>
                                <a href="<?$helper->urldispatch('editUser')?>?id=<?=$list[id_login]?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="<?$helper->urldispatch('editPrivileges')?>?id=<?=$list[id_login]?>"><i class="fa fa-key"></i></a>
                                <?}?>
                                <?if($_SESSION[privileges][users][delete] AND ($list[state] == 1 OR $list[state] == 0) ){?>
                                <a href="#" onClick="confirm_disable('<?=$list[id_login]?>','<?=$list[name].' '.$list[last_name]?>')" ><i class="fa fa-times"></i></a>
                                <?}?>
                                <?if($_SESSION[privileges][users][delete] AND $list[state] == 2){?>
                                <a href="#" onClick="confirm_enable('<?=$list[id_login]?>','<?=$list[name].' '.$list[last_name]?>')" ><i class="fa fa-check-square"></i></a>
                                 <?}?>
                            </td>
                        </tr>
                    <?endforeach?>
                    </tbody>
                </table>
                <div class="spacer-20"></div>
                <?if($_SESSION[privileges][users][edit]){?>
                <div class="row">
                    <div class="large-2 columns large-offset-10">
                      <a href="<?$helper->urldispatch('addUser')?>" class="button small">Agregar Usuario</a>
                    </div>
                </div>
                <?}?>
            </div>
        </div>
    </div>
    <div id="confirm-modal-disable" class="reveal-modal radius small" data-reveal aria-labelledby="confirm-modal" aria-hidden="true" role="dialog">
        <h4>Deshabilitaras un usuario de Minutrade. </h4><hr>
        <p>¿Estas seguro que deseas deshabilitar el usuario: <strong class="user"></strong>?</p>
        <button class="button alert" type="button" id="disable-btn"> Deshabilitar </button>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

    <div id="confirm-modal-enable" class="reveal-modal radius small" data-reveal aria-labelledby="confirm-modal" aria-hidden="true" role="dialog">
        <h4>habilitaras un usurio de Minutrade. </h4><hr>
        <p>¿Estas seguro que deseas habilitar el usuario: <strong class="user"></strong>?</p>
        <button class="button success" type="button" id="enable-btn"> habilitar </button>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>


    

<!-- End wrap -->
</div>

<!-- Load footer JS librarys -->
<?foreach($javascripts_ft AS $load_script):?>
<?=$load_script?>
<?endforeach;?>

<script>
$(document).foundation();
</script>

<script>
function confirm_disable(id,plan){
  $( ".user" ).empty();
  $( ".user" ).append(plan);
  $('#confirm-modal-disable').foundation('reveal','open');
  $("#disable-btn").click(function(){
    var url = "<?$helper->urldispatch('disableUser')?>?id="+id;
    $(location).attr('href',url);
  });
}

function confirm_enable(id,plan){
  $( ".user" ).empty();
  $( ".user" ).append(plan);
  $('#confirm-modal-enable').foundation('reveal','open');
  $("#enable-btn").click(function(){
    var url = "<?$helper->urldispatch('enableUser')?>?id="+id;
    $(location).attr('href',url);
  });
}

$(document).ready(function(){
  $('#tabla').DataTable();
  setTimeout(function(){
    $('.alert-box').hide('slow');
  }, 5000);
});
</script>

