<?php 

ob_start();

session_start();

$pageTitle = 'Comments';

if (isset($_SESSION['Username'])){

    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    if ($do == 'Manage'){  
        
                         
        $stmt = $con->prepare("select comments.*,items.Name as item,users.Username as user
                            from comments inner join 
                            items on items.item_ID = comments.item_ID
                            inner join
                            users on users.UserID = comments.user_ID
                            order by C_ID desc");      
        $stmt->execute();
                         
        $rows = $stmt->fetchAll();
        


    ?>
        <h1>Manage Comments</h1>
        <div class="Konteyner_G">
            <div >
                <table class="main_table">
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>User Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                    
                    <?php
                    
                         foreach($rows as $row){
                             
                             echo '<tr>';
                                echo '<td>' .$row['C_ID'] . '</td>';
                                echo '<td>' .$row['comment'] . '</td>';
                                echo '<td>' .$row['item'] . '</td>';
                                echo '<td>' .$row['user'] . '</td>';
                                echo '<td>'  .$row['comment_date']. '</td>';
                             echo '<td> <a href="comments.php?do=Edit&comid='. $row['C_ID'] . '" class="btn btn-success"><i class="far fa-edit"></i> Edit</a> 
                            <a href="comments.php?do=Delete&comid='. $row['C_ID'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> Delete</a>' ;
                            
                                if($row['status'] == 0){
                                    echo ' <a href="comments.php?do=Approve&comid='. $row['C_ID'] . '" class="btn btn-info"><i class="fas fa-plus"></i> Approve</a>';
                                }
                            
                             echo '</td>';
                             echo '</tr>';
                         }
                         
                    ?>
                             
                </table>
            </div> 
             
        </div>

   
<?php    }
    
    elseif ($do == 'Edit'){ 
        
        
           
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        
        
        
        $stmt = $con->prepare("select *  from comments 
                where C_ID = ?");
	    $stmt->execute(array($comid));
        $row = $stmt->fetch();
	    $count = $stmt->rowCount();

        if($count > 0){
        
     

?> 
        

        <h1>Edit Comment</h1>
        
        <div class="Konteyner_edit">
            <form action="?do=Update" method="POST">
                <input type="hidden" name="comid" value="<?php echo $comid ?>">
                <div >
                    <label class="">Comment</label>
                    <div class="">
                        <textarea class="inputss" name="comment"><?php echo $row['comment'] ;?></textarea>
                    
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
        
        echo '<h1>Update Comment</h1>';
        echo '<div class="Konteyner_G" >';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $comid = $_POST['comid'];
            $comment = $_POST['comment'];

           
            $stmt = $con->prepare("UPDATE comments SET comment = ? where C_ID = ?");
            $stmt->execute(array($comment , $comid));
            
            // message
            
            $msg='<div class="alrt alrtG">'. $stmt->rowCount() .' Record Updated ..</div>';
                
                redirectHome($msg ,'back',5);
            }
        
        else {
            $errMsg ='<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            redirectHome($errMsg ,5);
        }
        
        echo '</div>';
    } elseif ($do == 'Delete'){
        
        
        // Delete page
        echo '<h1>Delete Comment</h1>';
        echo '<div class="Konteyner_G" >';
        
           $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        
        // check comid 
        
        $check = checkItem('C_ID', 'comments',$comid);
        
        if($check > 0){
        
            $stmt = $con->prepare("delete from comments where C_ID = :zid");
            
            $stmt->bindParam(":zid",$comid);
            
            $stmt->execute();
            
            $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($msg ,'back',3);
            
        }else {
           $errMsg= '<div class="alrt alrtR" > This ID is Not Exist</div>';
            redirectHome($errMsg);
        }
        echo '</div>';
    } elseif ($do == 'Approve'){
        
        
        // activate page
        echo '<h1>Approve Comment</h1>';
        echo '<div class="Konteyner_G" >';
        
           $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        
        // check comid
        
        $check = checkItem('C_ID', 'comments',$comid);
        
        if($check > 0){
        
            $stmt = $con->prepare("update comments set status = 1 where C_ID = :zid");
            
            $stmt->bindParam(":zid",$comid);
            
            $stmt->execute();
            
            $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($msg ,'back',3);
            
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