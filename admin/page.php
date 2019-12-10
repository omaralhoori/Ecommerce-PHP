<?php
    
    $do = '';
    
    if( isset($_GET['do'])){
        $do = $_GET['do'];
    }

    else{
        $do = 'Manage';
    }

    if($do == 'Manage'){
        
        echo 'Welco to manage';
    }

    elseif ($do == 'Add'){
        
        echo 'Welcome to Add';
    }

    else {
        echo 'Error';
    }