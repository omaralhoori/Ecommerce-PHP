<?php
    $pageTitle = 'Sign Up';
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'signup';

    
    if($do == 'signup'){
     $a = rand(1,9);
     $b = rand(1,9);
     $c = $a + $b;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $css ;?>signup.css">
<div class="header"> 

</div>
  
<div class="main">
    <div class="login-box"> 
        <div class="login-swt">
            <span class="login-btn"><a href="login.php">GİRİŞ YAP</a></span>
            <span class="regs-btn"><span>KAYIT OL</span></span>
        </div>
        <div class="login-form">
            <form action="?do=Insert" method="post">
                <input type="hidden" name="capCode" value="<?php echo $c; ?>">
                <input type="email" name="email" placeholder="E-posta">
                <input type="password" name="password" placeholder="Sifre">
                <input type="password" name="password2" placeholder="Sifre yeniden girin">
                <input type="text" name="captcha" placeholder="<?php echo $a . ' + '.$b . ' = ?'; ?>">
                <span><input type="checkbox" > <span>Gearbest Gizlilik Politikasını ve Hüküm ve Koşullarınıkabul ediyorum. </span></span>
                <span><input type="checkbox" > <span>Verilen tüm bilgilerin kendime ait olduğunu onaylıyorum; Gearbest Gizlilik Politikası uyarınca kullanılacağını anlıyor ve kabul ediyorum; Onayımı istediğim zaman geri çekebilirim  </span></span>
                <input type="submit" value="KAYIT OL">
            </form>
        </div>
        <div class="login-other">
            <span>Veya aracılığıyla bağlan</span>
            <div>
            <span class="glp"><i class="fab fa-google-plus-g "></i></span>
            <span class="fbk"><i class="fab fa-facebook-f "></i></span>
            </div>
        </div>
    </div>
</div>

<div class="footer">

</div>

<?php 
    }elseif ($do == 'Insert'){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<h1>Kayit Olma</h1>';
            echo '<div class="Konteyner_G" >'; 
            
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $pass1 = $_POST['password2']; 
            $capt = $_POST['captcha']; 
            $captCode = $_POST['capCode'];
            
            $hashPass = sha1($pass);
            $formErrors = array();

            if (empty($email)){
                
                $formErrors[] = 'Eposta <strong>Girmedin </strong>.';
                
            }
            if (empty($pass)){
                
                $formErrors[] = 'Sifre <strong>Girmedin </strong>.';
            }
            
               if (empty($pass1)){
                
                $formErrors[] = 'Sifre yeniden <strong>Girmedin </strong>.';
            }
            if ($pass != $pass1){
                
                $formErrors[] = 'Sifreler Ayni <strong>Degil </strong>.';
            }
              
             if ($capt != $captCode){
                
                 $formErrors[] = 'Dogrulama kodu yanlis <strong> Girdin </strong>.';
            }

            foreach($formErrors as $error){
                echo '<div class="alrt alrtR">' . $error . '</div>' ;
            }     
                 
                 
            if(empty($formErrors)) {         
           
            $check = checkItem("Email","users",$email);
            
            if($check == 1){
                
                $errMsg = '<div class="alrt alrtR">Bu Kullanici Mucuttur</div>';
                redirectHome($errMsg ,'back');
            }
            else{
            
            // insert user
            
              

                $stmt = $con->prepare("insert into 
                users(Email , Password,Date)
                values(:zemail,:zpass,now())");

                $stmt->execute(array(
                    'zemail'   => $email,
                    'zpass'   => $hashPass  
                ));


                // message
                echo '
            <form id="myForm" action="active.php" method="post">
                   <input type="hidden" name="email" value="'.$email.'">
            ?>
            </form>
            <script type="text/javascript">
                document.getElementById("myForm").submit();
            </script>';   

            }
            }
        }
        else {
            $errorMsg= '<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            
            redirectHome($errorMsg ,3);
        }
        
        echo '</div>';
        
    }
    include $tpl. 'end.php';
?>