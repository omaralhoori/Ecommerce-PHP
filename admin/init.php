<?php

	include 'connect.php';

 	//routes

 	$tpl     = 'includes/templates/';//temlate directory
    $lang    = 'includes/languages/';
 	$func    = 'includes/functions/';
    $css     = 'layout/css/';//css directory
 	$js      = 'layout/js/';//js directory
 	
    //Language Select

    $select = array('tr','en');
    
    if(isset($_GET['lang']) && in_array($_GET['lang'] , $select)){
    $prefer = $_GET['lang'];
    }

    else{    
        $langs =explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $prefer = 'en';
         $select = array('tr');
        foreach ($langs  as $lan ){
            $lan = substr($lan , 0 ,2);
            if(in_array($lan , $select)){
                $prefer = $lan;
                break;
            }
        }
    }


 	//Includes
    include $func . 'func.php';
 	include $lang . $prefer .'.php';
 	include  $tpl . 'header.php';
 	

 	if(!isset($no_navbar)){
 		include $tpl . 'navbar.php';
 	}

 	?>