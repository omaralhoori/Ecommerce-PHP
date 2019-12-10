<?php

    session_start();

    session_unset();

    session_destroy();

    setcookie('user','', time() - 86400 , '/');

    header ('Location: index.php');

    exit();