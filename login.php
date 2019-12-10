<?php 
    ob_start();
	session_start();
    $pageTitle = 'Login';
    //check coming user
    include 'init.php';

    if(isset($_SESSION['User'])){
	header('Location: index.php');
    }
    if(isset($_COOKIE['user'])){
        $data = explode(',',$_COOKIE['user']);
        $email = $data[0];
        $hashedPass = $data[1];
        $stmt = $con->prepare("select UserID, Username, Password 
                from users 
                where Email = ? and Password=? limit 1");
	$stmt->execute(array($email , $hashedPass));
    $row = $stmt->fetch();
	$count = $stmt->rowCount();
    if($count>0){
        $_SESSION['User'] = $row['Username'];
        $_SESSION['Email'] = $email;
        $_SESSION['UserID'] = $row['UserID'];
		header('Location: index.php');
        exit();
    }
        
    }

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$email = $_POST['email'];
	$password = $_POST['password'];
	$hashedPass = sha1($password);

	//check if user exist

	$stmt = $con->prepare("select UserID, Username, Password 
                from users 
                where Email = ? and Password=? limit 1");
	$stmt->execute(array($email , $hashedPass));
    $row = $stmt->fetch();
	$count = $stmt->rowCount();

	if($count>0){
        if(isset($_POST['remember'])){
            setcookie('user',$email .','. $hashedPass  , time() + 86400 , '/');
        }
		$_SESSION['User'] = $row['Username'];
        $_SESSION['Email'] = $email;
        $_SESSION['UserID'] = $row['UserID'];
		header('Location: index.php');
        exit();
	}
    }

?>
<link rel="stylesheet" type="text/css" href="<?php echo $css ;?>login.css">
<div class="header"> 

</div>
<div class="main">
    <div class="login-box"> 
        <div class="login-swt">
            <span class="login-btn"><span>GİRİŞ YAP</span></span>
            <span class="regs-btn"><a href="signup.php">KAYIT OL</a></span>
        </div>
        <div class="login-form">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="email" name="email" placeholder="E-posta">
                <input type="password" name="password" placeholder="Sifre">
                <input type="checkbox" name="remember" value="checked"> <span>Oturumu acik tut</span>
                <span class="pass-forg"><a href="#">Parolanizi mi ununttunuz? </a></span>
                <input type="submit" value="Oturum Ac">
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
        include $tpl . 'end.php';
        ob_end_flush();
?>
