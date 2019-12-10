<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

if(isset($_COOKIE['user']) and empty($_SESSION['Email']))header('Location: login.php');
?>
<link rel="stylesheet" type="text/css" href="<?php echo $css ;?>style.css">
<header>
     <nav class="ust_header">
        <ul id="ustH_menu">
            <li class="ustH_items"  ><?php echo lang('country'); ?><i class="fa fa-angle-down"></i></li>
            <li class="ustH_items"  ><?php echo lang('language'); ?> <i class="fa fa-angle-down"></i>
                <div>
                    <ul>
                        <li><a href="?lang=tr">tr</a></li>
                        <li><a href="?lang=en">en</a></li>
                    </ul>
                </div>
            </li>
            <li class="ustH_items" id="ustH_item" ><?php echo lang('support_center'); ?></li>
            <li class="ustH_items"  ><?php echo lang('cont_site'); ?><i class="fa fa-angle-down"></i></li>
            
        </ul>
    </nav>
    <nav class="orta_Header">
        <div id="logo_H"><a href="index.php"><img src="imgs/logo.png" height="100px" width="100px"></a></div>
        <div id="arama_H">
            <div>
                <span class="kategori_H">
                    <span class="kategori" >
                        <span class="kategori_m" ><?php echo lang('all_cat'); ?></span >
                        <i class="fa fa-angle-down trans"></i>
                    </span>
                </span>
                <div class="kate_list">
                    <ul >   
                        <li><?php echo lang('all_cat'); ?></li>
                        <?php foreach(getCat() as $cat)
                            echo '<li>'.$cat['Name'].'</li>';
                        ?>
                    </ul>
                </div>
                <div class="arma_HBar">
                    <form>
                        <input type="text" class="aram_HBarS" placeholder="Ürün Ara">
                        <button ><i class="fas fa-search"></i></button>    
                    </form>
                </div>
            </div>
        </div>
    
        <div id="ortaH_menu">
            <div class="uyuluk_H_div">
                <i class="fas fa-user fa-2x uyuluk_ico"></i>
                <span class="uyuluk_H">
                    <a href="login.php"><?php 
                        
                        if(!empty($_SESSION['User']))
                            echo $_SESSION['User'];
                        else if (isset($_SESSION['Email'])) echo $_SESSION['Email'];
                        else
                        echo lang('LOGIN'); ?></a></span>
                <div class="uyuluk_H_Box">
                    <div class="kayit_ol">
                    <?php if(isset($_SESSION['User']))
                            echo '<a href="logout.php"> logout </a>';  
                        else
                        echo '<a href="signup.php"> Kayit ol </a>'; ?>
                    </div>
                    
                </div>
            </div>
            <div class="favor_H_div">
                <i class="far fa-heart fa-2x favor_ico"></i>
                <span class="favor_H"><a href="#">Favorilerim</a></span>
            </div>
            <div class="sepet_H_div">
                <i class="fas fa-cart-arrow-down fa-2x sepet_ico"></i>
                <span class="sepet_H"><i class="fas fa-circle circ"><span class="counter_sepet">0</span></i></span>
                <p><a href="#">Sepet</a></p>
                <div class="sepet_H_Box"></div>
            </div>
        </div>
    </nav>
    <nav class="alt_header">
        <div class="alt_H_menu" id="alt_h_kategori"><span>BİR KATEGORİ SEÇİN </span><i class="fa fa-angle-down"></i>
            <div id="alt_h_katDiv">
                <ul>
                <?php 
                    foreach(getCat() as $cat){
                     echo '<li>'. '<a href="#"> '  . $cat['Name'] . '</a></li>' ;  
                    }
                ?>
                </ul>
                <!--<div class="alt_h_yanMenu">
                            <div>
                                <ul>Cep Telefonlar
                                    <li><a href="#">Akılı Telefonlar</a></li>
                                    <li><a href="#">Akılı Telefonlar</a></li>
                                </ul>
                            </div>
                             <div> 
                                 <ul>Cep Telefonlar
                                    <li><a href="#">Akılı Telefonlar</a></li>
                                    <li><a href="#">Akılı Telefonlar</a></li>
                                 </ul>
                            </div>
                            <div> 
                                <ul>Cep Telefonlar
                                    <li><a href="#">Akılı Telefonlar</a></li>
                                    <li><a href="#">Akılı Telefonlar</a></li>
                                </ul>
                            </div>

                        </div>-->

            </div>
        </div>
        <div class="alt_H_menu" id="alt_h_kupon"><span>KUPONLAR </span><i class="fa fa-angle-down"></i></div>
        <div class="alt_H_menu" id="alt_h_kesfet"><span>KEŞFET </span><i class="fa fa-angle-down"></i></div>
    </nav>
    <script src="<?php echo $js; ?>script.js"></script>
</header>
