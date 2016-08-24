<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?=$title?></title>

        <?if($expires):?>
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="expires" content="0">  
        <?endif?>

        <link rel="shortcut icon" href="<?$helper->urldispatch('images')?>favicon.ico"> 

        <!-- Load CSS librarys -->
        <?foreach($stylesheets AS $load_css):?>
     <?=$load_css?>
        <?endforeach;?>

        <!-- Load header Javascript librarys -->
        <?foreach($javascripts AS $load_script):?>
     <?=$load_script?>
        <?endforeach;?>
    </head>
    
    <body>
        <!-- Wrap all page content here -->
        <div id="wrap">

            <?if($_SESSION):?>
            <div class="movistar-header">
                <div class="row">
                    <div class="large-2 columns">
                        <a href="<?$helper->urldispatch('home')?>">
                           <img src="<?$helper->urldispatch('images')?>movistar-logo.png" />
                        </a>
                    </div>
                    <div class="large-8 columns" style="padding-top:1em">
                        Conectado como:  <strong><?if($_SESSION[userInfo]){?><?=$_SESSION[userInfo][name].' '.$_SESSION[userInfo][last_name]?> <?} else {?><?=$_SESSION[user_login]?> <?}?></strong>
                    </div>
                    <div class="large-2 columns" style="padding-top:1em">
                        <a href="<?$helper->urldispatch('destroy_session')?>" ><i class="fa fa-times fa-inverse"></i> Cerrar Sesión </a>
                    </div>
             </div>
        </div>
        <?endif;?>
