<?php 
    /*
		test :
		admin : omar
		pass : 12345
    */
    ob_start();

	session_start();
	$no_navbar='';
    $pageTitle = 'Login';
if(isset($_SESSION['Username'])){
	header('Location: dashboard.php');
    //echo "<script> window.location.replace('dashboard.php') </script>";
}
include 'init.php';

	
	//check coming user

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$username = $_POST['user'];
	$password = $_POST['pass'];
	$hashedPass = sha1($password);

	//check if user exist

	$stmt = $con->prepare("select UserID, Username, Password 
                from users 
                where Username = ? and Password=? and GroupID=1 limit 1");
	$stmt->execute(array($username , $hashedPass));
    $row = $stmt->fetch();
	$count = $stmt->rowCount();

	if($count>0){
		$_SESSION['Username'] = $username;
        $_SESSION['ID'] = $row['UserID'];
		//echo "<script> window.location.replace('dashboard.php') </script>";
		header('Location: dashboard.php');
        exit();

	}
	
}

?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="off" />
		<input class="btn btn-primary btn-block" 	type="submit" value="login"  />
	</form> 

<?php include $tpl . 'footer.php';
          ob_end_flush();
?>