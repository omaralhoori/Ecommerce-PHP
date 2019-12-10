<?php 

    include 'init.php';
    include $tpl . 'header.php';
    include 'slider1.php';
    include $tpl . 'slider2.php';
    echo '<ul class="items-menu">';
        foreach(getItems() as $item){
            echo '<li>';include $tpl . 'item.php';echo '</li>';
        }
    echo '</ul>';
    include $tpl . 'aside.php';
    include $tpl . 'footer.php';
    include $tpl . 'end.php';

?>
