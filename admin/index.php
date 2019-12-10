<?php 

    /*
		test :
		admin : omar
		pass : 12345
    */

ob_start();
header('Location: login.php');
ob_flush();
?>