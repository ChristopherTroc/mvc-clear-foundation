
<div class="spacer-20"></div>

<!-- Nav Bar -->
<div class="row">
    <div class="large-12 columns">
        <div class="spacer-30"></div>
        <div class="sticky">
            <nav class="top-bar" data-topbar role="navigation">
                <ul class="title-area">
                   <li class="name">
                       <img src="<?$helper->urldispatch('images')?>logo-qin.png" class="logo-qin" />
                   </li>
                   <li class="toggle-topbar menu-icon">
                       <a href="#" ><span></span></a>
                   </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="left">
                        <li class="app-name"> Minutrade </li>
                    </ul>
                    <ul class="right">
                        <li <?if($active == 'whiteList')  { ?> class="active" <?}?> ><a href="<?$helper->urldispatch('whiteList')?>  ">Lista Blanca IPs</a></li>
                        <li <?if($active == 'customers')  { ?> class="active" <?}?> ><a href="<?$helper->urldispatch('customers')?>  ">Clientes Corporativos</a></li>
                        <li <?if($active == 'credentials'){ ?> class="active" <?}?> ><a href="<?$helper->urldispatch('credentials')?>">Credenciales</a></li>
                        <!--<li <?if($active == 'tmRestrictions'){ ?> class="active" <?}?> ><a href="<?$helper->urldispatch('timeRestrictions')?>">Restricción Horaria SMS</a></li> -->
                        <li class="has-dropdown">
                           <a href="#"> Sistema </a>
                           <ul class="dropdown">
                                <?if($_SESSION[privileges][users][view]){?>
                               <li <?if($active == 'Users')  { ?> class="active" <?}?> ><a href="<?$helper->urldispatch('Users')?>  ">Usuarios</a></li>
                               <?}?>
                               <li <?if($active == 'logs')     { ?> class="active" <?}?> ><a href="<?$helper->urldispatch('logs')?>  ">Log's de Transacciones</a></li>
                               <li <?if($active == 'logsSMS')  { ?> class="active" <?}?> ><a href="<?$helper->urldispatch('logsSMS')?>  ">Log's SMS</a></li>
                               <li <?if($active == 'logsAuth') { ?> class="active" <?}?> ><a href="<?$helper->urldispatch('logsAuth')?>  ">Log's Autenticación</a></li>
                           </ul>
                       </li>
                    </ul>
                </section>
            </nav>
            <ul class="breadcrumbs">
             <?if($active=='whiteList'){?>Lista Blanca de Ips<li></li><?}?>
             <?if($active=='customers'){?>Clientes Corporativos<li></li><?}?>
             <?if($active=='credentials'){?>Credenciales<li></li><?}?>
             <?if($active=='tmRestrictions'){?>Restriccion Horaria SMS<li></li><?}?>
             <?if($active=='Users'){?>Usuarios<li></li><?}?>
             <?if($active=='logs'){?>Log's de transacciones<li></li><?}?>
             <?if($active=='logsSMS'){?>SMS Log's <li></li><?}?>
             <?if($active=='logsAuth'){?>Autenticación Log's <li></li><?}?>
            </ul>
        </div>
    </div>
</div>


