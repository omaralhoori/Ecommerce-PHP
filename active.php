<?php 
	ob_start();
	session_start();
	include 'init.php';
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['send'])){
			if($_POST['code'] == $_SESSION['code']){
				 $stmt = $con->prepare("update users set RegStatus = 1 
                where Email = :zemail");

                $stmt->execute(array(
                    'zemail'   => $_POST['email'],
                ));

                // message

                $msg= '<div class="alrt alrtG"> account activated</div>';
                   
                redirectHome($msg); 
			}else{
				echo 'yanlis code girmistin';
			}
		}
	
		else{
			$emailoz = 'omaralhooritest@gmail.com';
			$passos = 'xzaq13579';
			require $func.'mailer/PHPMailerAutoload.php';
			$code = rand(100000,999999);
			$mail = new PHPMailer;

			//$mail->SMTPDebug = 3;                               // Enable verbose debug output

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $emailoz;                 // SMTP username
			$mail->Password = $passos;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to

			$mail->setFrom($emailoz, 'Mailer');
			$mail->addAddress($_POST['email'], 'New User');     // Add a recipient             // Name is optional
			$mail->addReplyTo($emailoz);
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'email activation code';
			$mail->Body    = 'Your activation code is :' . $code;

			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				$_SESSION['code'] = $code;
				echo '<div class="Konteyner_G">';
				    echo '<div class="alrt alrtG">activation code has been sent to your email</div>';
				    echo '
				    	<form action="'.$_SERVER["PHP_SELF"].'" method="POST" class="active-form">
				    		<input type="hidden" value="'. $_POST['email'] .'" name="email">
				    		<input type="text" name="code" placeholder="activation code"><br/>
				    		<input type="submit" name="send" value="activate">
				    	</form>
				    ';
			    echo '</div>';
			}
		}

	}
	else redirectHome('Yanlis yoldan geldin .');

	ob_flush();
?>
<for