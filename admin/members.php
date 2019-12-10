<?php 

ob_start();

session_start();

$pageTitle = 'Members';

if (isset($_SESSION['Username'])){

    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    if ($do == 'Manage'){  
        
        $query = '';
        
        if (isset($_GET['page']) && $_GET['page'] == 'Pending'){
            
            $query = 'AND RegStatus = 0';
        }
        
                         
        $stmt = $con->prepare("select * from users where GroupID !=1 $query");      
        $stmt->execute();
                         
        $rows = $stmt->fetchAll();
        


    ?>
        <h1>Add New Member</h1>
        <div class="Konteyner_G">
            <div >
                <table class="main_table">
                    <tr>
                        <td>#ID</td>
                        <td>username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <td>Control</td>
                    </tr>
                    
                    <?php
                    
                         foreach($rows as $row){
                             
                             echo '<tr>';
                                echo '<td>' .$row['UserID'] . '</td>';
                                echo '<td>' .$row['Username'] . '</td>';
                                echo '<td>' .$row['Email'] . '</td>';
                                echo '<td>' .$row['Fullname'] . '</td>';
                                echo '<td>'  .$row['Date']. '</td>';
                             echo '<td> <a href="members.php?do=Edit&userid='. $row['UserID'] . '" class="btn btn-success"><i class="far fa-edit"></i> Edit</a> 
                            <a href="members.php?do=Delete&userid='. $row['UserID'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> Delete</a>' ;
                            
                                if($row['RegStatus'] == 0){
                                    echo ' <a href="members.php?do=Activate&userid='. $row['UserID'] . '" class="btn btn-info"><i class="fas fa-plus"></i> Activate</a>';
                                }
                            
                             echo '</td>';
                             echo '</tr>';
                         }
                         
                    ?>
                             
                </table>
            </div> 
             <a href="members.php?do=Add" class="btn btn-primary">Add new member</a>
        </div>

   
<?php    }elseif ($do == 'Add'){
        // Add Members Page ---------------------------------
        
        ?>         

        <h1>Add New Member</h1>
        
        <div class="Konteyner_edit">
            <form action="?do=Insert" method="POST">
                <div >
                    <label class="">Username</label>
                    <div class="">
                    <input type="text" name="username" class="inputss" autocomplete="off" required="required" placeholder="Username To login Into Shop">
                    
                    </div>
                </div>
                <div >
                    <label class="">Password</label>
                    <div class="">      
                    <input type="password" name="password" class="password inputss" autocomplete="new-password" required="required"  placeholder="Password Must be hard">
                    <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                </div>
                <div >
                    <label class="">Email</label>
                    <div class="">
                    <input type="email" name="email" class="inputss" required="required"  placeholder="Email Must Be Valid">
                    
                    </div>
                </div>
                <div >
                    <label class="">Full Name</label>
                    <div class="">
                    <input type="text" name="fullN" class="inputss" required="required"   placeholder="Full Name Apper in Profile">
                    
                    </div>
                </div>
                <div >  
                    <div class="">
                    <input type="submit" value="Add" class="btn_e" style="width: 100px;" >
                    
                    </div>
                </div>
            </form>
        </div>
     <?php
        
    } elseif ($do == 'Insert'){
        
        // insert page -----------------------
        
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<h1>Insert Member</h1>';
        echo '<div class="Konteyner_G" >'; 
            
            
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $email = $_POST['email'];
            $name = $_POST['fullN'];
            
            $hashPass = sha1($pass);
            
             // valdiate form 
            
            $formErrors = array();
            
            if(strlen($user) < 4){
             $formErrors[] = 'Username Cant Be less than<strong> 4 characters </strong>.';   
            }
            
            if(strlen($user) > 20){
             $formErrors[] = 'Username Cant Be more than<strong> 20 characters </strong>.';   
            }
            
            if (empty($user)){
                
                $formErrors[] = 'Username Cant Be <strong>Empty </strong>.';
                
            }
            if (empty($pass)){
                
                $formErrors[] = 'Password Cant Be <strong>Empty </strong>.';
            }
            
               if (empty($name)){
                
                $formErrors[] = 'FullName Cant Be <strong>Empty </strong>.';
            }
               if (empty($email)){
                
                 $formErrors[] = 'Email Cant Be<strong> Empty </strong>.';
            }
            
            foreach($formErrors as $error){
                
                echo '<div class="alrt alrtR">' . $error . '</div>' ;
            }
            
            // check if user exist
            
            $check = checkItem("Username","users",$user);
            
            if($check == 1){
                
                $errMsg = '<div class="alrt alrtR">Sorry This User Is Exist</div>';
                redirectHome($errMsg ,'back');
            }
            else{
            
            // insert user
            
               if(empty($formErrors)){

                $stmt = $con->prepare("insert into 
                users(Username , Password ,Email ,Fullname, RegStatus , Date)
                values(:zuser, :zpass, :zmail, :zname, 1,now())");

                $stmt->execute(array(
                    'zuser' => $user,
                    'zpass' => $hashPass,
                    'zmail' => $email,
                    'zname' => $name    
                ));


                // message

                $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Inserted</div>';
                   
                redirectHome($msg ,'back' ,6);   

                }
            }
        }
        else {
            $errorMsg= '<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            
            redirectHome($errorMsg ,'back' ,6);
        }
        
        echo '</div>';
        
    }
    
    
    elseif ($do == 'Edit'){ 
        
        
           
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
        
        
        $stmt = $con->prepare("select *  from users 
                where UserID = ? limit 1");
	    $stmt->execute(array($userid));
        $row = $stmt->fetch();
	    $count = $stmt->rowCount();
        $fullNam = $row['Fullname'];
        if($count > 0){
        
     

?> 
        

        <h1>Edit Member</h1>
        
        <div class="Konteyner_edit">
            <form action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid ?>">
                <div >
                    <label class="">Username</label>
                    <div class="">
                    <input type="text" name="username" class="inputss" value=<?php echo $row['Username']; ?> autocomplete="off" required="required">
                    
                    </div>
                </div>
                <div >
                    <label class="">Password</label>
                    <div class="">
                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" >
                    <input type="password" name="password" class="inputss" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change">
                    
                    </div>
                </div>
                <div >
                    <label class="">Email</label>
                    <div class="">
                    <input type="email" name="email" class="inputss" value=<?php echo $row['Email']; ?> required="required">
                    
                    </div>
                </div>
                <div >
                    <label class="">Full Name</label>
                    <div class="">
                    <input type="text" name="fullN" class="inputss" value=<?php echo $fullNam; ?> required="required">
                    
                    </div>
                </div>
                <div >  
                    <div class="">
                    <input type="submit" value="Save" class="btn_e" style="width: 100px;" >
                    
                    </div>
                </div>
            </form>
        </div>
     <?php
        } else {
            $errMsg= '<div class="alrt alrtR"There is no such id</div>';
            redirectHome($errMsg ,5);
        
        }    
    }  
    
    
    elseif ($do == 'Update'){
        
        echo '<h1>Update Member</h1>';
        echo '<div class="Konteyner_G" >';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['fullN'];
            
            //password
            
            $pass= empty($_POST['password']) ? $_POST['oldpassword'] : sha1($_POST['password']); 
             // valdiate form 
            
            $formErrors = array();
            
            if(strlen($user) < 4){
             $formErrors[] = 'Username Cant Be less than<strong> 4 characters </strong>.';   
            }
            
            if(strlen($user) > 20){
             $formErrors[] = 'Username Cant Be more than<strong> 20 characters </strong>.';   
            }
            
            if (empty($user)){
                
                $formErrors[] = 'Username Cant Be <strong>Empty </strong>.';
                
            }
               if (empty($name)){
                
                $formErrors[] = 'FullName Cant Be <strong>Empty </strong>.';
            }
               if (empty($email)){
                
                 $formErrors[] = 'Email Cant Be<strong> Empty </strong>.';
            }
            
            foreach($formErrors as $error){
                
                echo '<div class="alrt alrtR">' . $error . '</div>' ;
            }
            
            // Update
            if(empty($formErrors)){
                $stmt2 = $con->prepare("select * from users where Username = ? and UserID != ?");
                $stmt2->execute(array($user,$id));
                
                $count = $stmt2->rowCount();
                
                if($count == 1 ){
                    $msg = '<div class="alrt alrtR"> Sory this user is exist </div>';
                    redirectHome($msg ,'back',2);
                }else{
                    
                     $stmt = $con->prepare("UPDATE users SET Username = ? ,Password = ? ,Email = ? , Fullname = ? where UserID = ?");
            $stmt->execute(array($user, $pass ,$email,$name,$id));
            
            // message
            
            $msg='<div class="alrt alrtG">'. $stmt->rowCount() .' Record Updated ..</div>';
                     redirectHome($msg ,'back',3);
                }
                
              /*
                
           
                
                */
            }
        }
        else {
            $errMsg ='<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            redirectHome($errMsg ,5);
        }
        
        echo '</div>';
    } elseif ($do == 'Delete'){
        
        
        // Delete page
        echo '<h1>Delete Member</h1>';
        echo '<div class="Konteyner_G" >';
        
           $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
        // check userId 
        
        $check = checkItem('userid', 'users',$userid);
        
        if($check > 0){
        
            $stmt = $con->prepare("delete from users where UserID = :zuser");
            
            $stmt->bindParam(":zuser",$userid);
            
            $stmt->execute();
            
            $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($msg ,'back',5);
            
        }else {
           $errMsg= '<div class="alrt alrtR" > This ID is Not Exist</div>';
            redirectHome($errMsg ,5);
        }
        echo '</div>';
    } elseif ($do == 'Activate'){
        
        
        // activate page
        echo '<h1>Activate Member</h1>';
        echo '<div class="Konteyner_G" >';
        
           $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
        // check userId 
        
        $check = checkItem('userid', 'users',$userid);
        
        if($check > 0){
        
            $stmt = $con->prepare("update users set RegStatus = 1 where UserID = :zuser");
            
            $stmt->bindParam(":zuser",$userid);
            
            $stmt->execute();
            
            $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($msg ,'back',5);
            
        }else {
           $errMsg= '<div class="alrt alrtR" > This ID is Not Exist</div>';
            redirectHome($errMsg ,5);
        }
        echo '</div>';
    }
    
    
    include $tpl . 'footer.php';
}
else {

	echo "<script> window.location.replace('login.php') </script>";
	exit();
}

    ob_end_flush();


?>