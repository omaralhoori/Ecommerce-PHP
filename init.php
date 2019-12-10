<?php

	include 'admin/connect.php';

 	//routes

 	$tpl     = 'includes/templates/';//temlate directory
    $lang    = 'includes/languages/';
 	$func    = 'includes/functions/';
    $css     = 'layout/css/';//css directory
 	$js      = 'layout/js/';//js directory
    
    //language select
    $select = array('tr','en');
    if(!isset($_SESSION))
            session_start();

    if(isset($_GET['lang']) && in_array($_GET['lang'] , $select)){
        $_SESSION['lang'] = $_GET['lang'];
    }

    else{

        if(!isset($_SESSION['lang'])){
        $langs =explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $_SESSION['lang'] = 'en';
        $select = array('tr');
        foreach ($langs  as $lan ){
            $lan = substr($lan , 0 ,2);
            if(in_array($lan , $select)){
                $_SESSION['lang'] = $lan;
                break;
                }
            }
        }
    }
 	//Includes
    include $func . 'func.php';
 	include $lang .  $_SESSION['lang'] . '.php';
 	include $tpl . 'start.php';

 	?>