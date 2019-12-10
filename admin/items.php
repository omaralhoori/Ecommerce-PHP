<?php 

ob_start();

session_start();

$pageTitle = 'Items';

if (isset($_SESSION['Username'])){

    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    if ($do == 'Manage'){        
                         
        $stmt = $con->prepare("select items.*,categories.Name as category_name,users.Username as member_name from items
                                inner join categories on categories.ID = items.Cat_ID
                                inner join users      on users.UserID = items.Member_ID");      
        $stmt->execute();
                         
        $items = $stmt->fetchAll();
        


    ?>
        <h1>Manage Items</h1>
        <div class="Konteyner_G">
            <div >
                <table class="main_table">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Control</td>
                    </tr>
                    
                    <?php
                    
                         foreach($items as $item){
                             
                             echo '<tr>';
                                echo '<td>' .$item['item_ID'] . '</td>';
                                echo '<td>' .$item['Name'] . '</td>';
                                echo '<td>' .$item['Description'] . '</td>';
                                echo '<td>' .$item['Price'] . '</td>';
                                echo '<td>'  .$item['Add_Date']. '</td>';
                                echo '<td>' .$item['category_name'] . '</td>';
                                echo '<td>'  .$item['member_name']. '</td>';
                                echo '<td> <a href="items.php?do=Edit&itemid='. $item['item_ID'] . '" class="btn btn-success"><i class="far fa-edit"></i> Edit</a> 
                            <a href="items.php?do=Delete&itemid='. $item['item_ID'] . '" class="btn btn-danger confirm"><i class="fas fa-times"></i> Delete</a>' ;
                                if($item['Approve'] == 0){
                                    echo ' <a href="items.php?do=Approve&itemid='. $item['item_ID'] . '" class="btn btn-info"><i class="fas fa-plus"></i> Approve</a>';
                                }
                             
                                echo '</td>';
                            echo '</tr>';
                         }
                         
                    ?>
                             
                </table>
            </div> 
             <a href="items.php?do=Add" class="btn btn-primary">Add new Item</a>
        </div>

   
<?php   
    
    }
    
    elseif ($do == 'Add'){
            ?>
        <h1>Add New Item</h1>
        
        <div class="Konteyner_edit">
            <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                <div >
                    <label class="">Name</label>
                    <div class="">
                    <input type="text" name="name" class="inputss" required="required" placeholder="Name Of The Item">
                    
                    </div>
                </div>
                <div >
                    <label class="">Description</label>
                    <div class="">
                    <input type="text" name="description" class="inputss" required="required" placeholder="Description Of The Item">
                    
                    </div>
                </div>
                <div >
                    <label class="">Price</label>
                    <div class="">
                    <input type="text" name="price" class="inputss" required="required" placeholder="Price Of The Item">
                    
                    </div>
                </div>
                <div >
                    <label class="">Discount</label>
                    <div class="">
                    <input type="text" name="discount" class="inputss"  placeholder="Discount for the item">
                    
                    </div>
                </div>
                <div >
                    <label class="">Country</label>
                    <div class="">
                    <input type="text" name="country" class="inputss" required="required"  placeholder="Country Of The Item">
                    
                    </div>
                </div>
                <div >
                    <label class="">Images</label>
                    <div class="">
                    <input type="file" name="itmImg[]" class="inputss" required="required"  placeholder="Country Of The Item" multiple>
                    
                    </div>
                </div>
                <div >
                    <label class="">Status</label>
                    <div class="">
                        <select name="status" class="inputss">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Old</option>
                            <option value="4">Very Old</option>
                        </select>
                    
                    </div>
                </div>
                <div >
                    <label class="">Member</label>
                    <div class="">
                        <select name="member" class="inputss">
                            <option value="0">...</option>
                            <?php 
                                $stmt2 = $con->prepare("select * from users");
                                $stmt2->execute();
                                $users = $stmt2->fetchAll();
                                foreach($users as $user){
                                    echo "<option value='".$user['UserID']."'>".$user['Username']."</option>";
                                }
                            ?>
                        </select>
                    
                    </div>
                </div> 
                <div >
                    <label class="">Category</label>
                    <div class="">
                        <select name="category" class="inputss">
                            <option value="0">...</option>
                            <?php 
                                $stmt2 = $con->prepare("select * from categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                                foreach($cats as $cat){
                                    echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                                }
                            ?>
                        </select>
                    
                    </div>
                </div> 
                <div >  
                    <div class="">
                    <input type="submit" value="Add Item" class="btn_e" style="width: 100px;" >
                    
                    </div>
                </div>
            </form>
        </div>


    <?php
    }
    
    elseif ($do == 'Insert'){ 
    
             if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<h1>Insert Item</h1>';
            echo '<div class="Konteyner_G" >';
                        
                 
            
            
            
                          
            
            //----------------
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $disc = $_POST['discount'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member  = $_POST['member'];
            $cat     = $_POST['category']; 
                 
            $formErrors = array();
                 
            $imgAlwExt = array("jpeg","jpg","png","gif");
                 
            if(!empty(array_filter($_FILES['itmImg']['name']))){
                    foreach($_FILES['itmImg']['name'] as $key=>$val){
                        $imgName =  $_FILES['itmImg']['name'][$key];    
                        $imgSize =  $_FILES['itmImg']['size'][$key];
                        $imgTmp  =  $_FILES['itmImg']['tmp_name'][$key];
                        $imgTyp  =  $_FILES['itmImg']['type'][$key];
                        
                        $imgExt = @strtolower(end(explode('.',$imgName)));
                        if(!empty($imgName)&&!in_array($imgExt ,$imgAlwExt)){
                         $formErrors[] = $imgExt .' Extensiton is not<strong> allowed </strong>.';
                     }
                        if(empty($imgName)){
                         $formErrors[] = 'Image must be <strong> Set </strong>.';
                     }
                        if($imgSize > 4194304){
                         $formErrors[] = 'This Image ['.$imgName. ']is too<strong> Large </strong>.';
                     }
                        
                    }
                }       
                 
            if (empty($name)){
                
                $formErrors[] = 'Name Cant Be <strong>Empty </strong>.';
                
            }
            if (empty($desc)){
                
                $formErrors[] = 'Description Cant Be <strong>Empty </strong>.';
            }
            if (empty($price)){
                
                $formErrors[] = 'Price Cant Be <strong>Empty </strong>.';
            }
            if (empty($country)){
                
                 $formErrors[] = 'country Cant Be<strong> Empty </strong>.';
            }
            if ($status == 0){
                
                 $formErrors[] = 'You Must Choose the<strong> Status </strong>.';
            }
            if ($member == 0){
                
                 $formErrors[] = 'You Must Choose the<strong> Member </strong>.';
            }
            if ($cat == 0){
                
                 $formErrors[] = 'You Must Choose the<strong> Category </strong>.';
            }
            
            foreach($formErrors as $error){
                echo '<div class="alrt alrtR">' . $error . '</div>' ;
            }     
                 
                 
            if(empty($formErrors)) {    
            // check if category exist
             
               
           
            $check = checkItem("Name","items",$name);
            
            if($check == 1){
                
                $errMsg = '<div class="alrt alrtR">Sorry This Item Is Exist</div>';
                redirectHome($errMsg ,'back');
            }
            else{
            
            // insert user
            
              

                $stmt = $con->prepare("insert into 
                items(Name , Description ,Price ,discount,Country_Made, Status  , Add_Date,Cat_ID,Member_ID )
                values(:zname, :zdesc, :zprice,:zdisc ,:zcountry, :zstatus,now(),:zcat,:zmember)");

                $stmt->execute(array(
                    'zname'   => $name,
                    'zdesc'   => $desc,
                    'zprice'  => $price,
                    'zdisc'   => $disc,
                    'zcountry'=> $country,
                    'zstatus' => $status,
                    'zcat'    => $cat,
                    'zmember' => $member
                ));
                
                $itmID = getSelect('item_ID', 'items' , 'Name' , $name);

         
                foreach($_FILES['itmImg']['name'] as $key=>$val){
                        $imgName =  $_FILES['itmImg']['name'][$key];    
                        $imgSize =  $_FILES['itmImg']['size'][$key];
                        $imgTmp  =  $_FILES['itmImg']['tmp_name'][$key];
                        $imgTyp  =  $_FILES['itmImg']['type'][$key];
                        
                        $itmImg = rand(0,1000000000).'_'.$imgName;
                        
                        move_uploaded_file($imgTmp,'uploads\itmImgs\\'.$itmImg);
                        
                    $stmt3 = $con->prepare("insert into imgs_item(itemID ,imgName , uploadDate)
                                                        values(:zitmID, :zname , now())");
                    
                    $stmt3->execute(array(
                            'zitmID'    => $itmID[0][0],
                            'zname'     => $itmImg
                        ));
             }
                

                // message

                $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Inserted</div>';
                   
                redirectHome($msg ,'back' ,6);   

            }
            }
        }
        else {
            $errorMsg= '<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            
            redirectHome($errorMsg ,6);
        }
        
        echo '</div>';
        
        
    
    }
    
    elseif ($do == 'Edit'){ 
      
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
     
        
        $stmt = $con->prepare("select *  from items 
                where item_ID = ?");
	    $stmt->execute(array($itemid));
        $item = $stmt->fetch();
	    $count = $stmt->rowCount();

        if($count > 0){
?> 
        <h1>Edit Item</h1>
        
        <div class="Konteyner_edit">
            <form action="?do=Update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                <div >
                    <label class="">Name</label>
                    <div class="">
                    <input type="text" name="name" class="inputss" required="required" placeholder="Name Of The Item" value="<?php echo $item['Name']; ?>">
                    
                    </div>
                </div>
                <div >
                    <label class="">Description</label>
                    <div class="">
                    <input type="text" name="description" class="inputss" required="required" placeholder="Description Of The Item" value="<?php echo $item['Description']; ?>">
                    
                    </div>
                </div>
                <div >
                    <label class="">Price</label>
                    <div class="">
                    <input type="text" name="price" class="inputss" required="required" placeholder="Price Of The Item" value="<?php echo $item['Price']; ?>">
                    
                    </div>
                </div>
                <div >
                    <label class="">Discount</label>
                    <div class="">
                    <input type="text" name="discount" class="inputss" placeholder="Discount for The Item" value="<?php echo $item['discount']; ?>">
                    
                    </div>
                </div>
                <div >
                    <label class="">Country</label>
                    <div class="">
                    <input type="text" name="country" class="inputss" required="required"  placeholder="Country Of The Item" value="<?php echo $item['Country_Made']; ?>">
                    
                    </div>
                </div>
                <div >
                    <label class="">Image</label>
                    <div class="">
                    <input type="file" name="itmImg" class="inputss"  value="">
                    </div>
                </div>
                <div >
                    <label class="">Status</label>
                    <div class="">
                        <select name="status" class="inputss">
                            <option value="1" <?php if($item['Status'] == 1) echo 'selected'; ?>>New</option>
                            <option value="2" <?php if($item['Status'] == 2) echo 'selected'; ?>>Like New</option>
                            <option value="3" <?php if($item['Status'] == 3) echo 'selected'; ?>>Old</option>
                            <option value="4" <?php if($item['Status'] == 4) echo 'selected'; ?>>Very Old</option>
                        </select>
                    
                    </div>
                </div>
                <div >
                    <label class="">Member</label>
                    <div class="">
                        <select name="member" class="inputss">
                            <?php 
                                $stmt2 = $con->prepare("select * from users");
                                $stmt2->execute();
                                $users = $stmt2->fetchAll();
                                foreach($users as $user){
                                    echo "<option value='".$user['UserID']."'";
                                    if($item['Member_ID'] == $user['UserID']) echo 'selected'; 
                                    echo ">".$user['Username']."</option>";
                                }
                            ?>
                        </select>
                    
                    </div>
                </div> 
                <div >
                    <label class="">Category</label>
                    <div class="">
                        <select name="category" class="inputss">
                            <?php 
                                $stmt2 = $con->prepare("select * from categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                                foreach($cats as $cat){
                                    echo "<option value='".$cat['ID']."'";
                                    if($item['Cat_ID'] == $cat['ID']) echo 'selected'; 
                                    echo ">".$cat['Name']."</option>";
                                }
                            ?>
                        </select>
                    
                    </div>
                </div> 
                <div >  
                    <div class="">
                    <input type="submit" value="Save Item" class="btn_e" style="width: 100px;" >
                    
                    </div>
                </div>
            </form>
            
    <?php
             $stmt = $con->prepare("select comments.*,users.Username as user
                            from comments inner join
                            users on users.UserID = comments.user_ID
                            where item_ID = ?");      
        $stmt->execute(array($itemid));
                         
        $rows = $stmt->fetchAll();
        
        if(! empty($rows)){


    ?>
        <h1>Manage [<?php echo $item['Name']; ?> ] Comments</h1>
        <div class="Konteyner_G">
            <div >
                <table class="main_table">
                    <tr>
                        <td>Comment</td>
                        <td>User Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                    
                    <?php
                    
                         foreach($rows as $row){
                             
                             echo '<tr>';
                                echo '<td>' .$row['comment'] . '</td>';
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
    
            
        </div>

     <?php
        } } else {
            $errMsg= '<div class="alrt alrtR">There is no such id</div>';
            redirectHome($errMsg ,5);
        
        }    
    
    }
    
    elseif ($do == 'Update'){
        
        echo '<h1>Update Item</h1>';
        echo '<div class="Konteyner_G" >';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(!empty($_FILES['itmImg']['name'])){
            $imgName =  $_FILES['itmImg']['name'];    
            $imgSize =  $_FILES['itmImg']['size'];
            $imgTmp  =  $_FILES['itmImg']['tmp_name'];
            $imgTyp  =  $_FILES['itmImg']['type'];
                 
            $imgAlwExt = array("jpeg","jpg","png","gif");
            
            $imgExt = @strtolower(end(explode('.',$imgName)));
            }
            
            $id = $_POST['itemid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $disc = $_POST['discount'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $cat = $_POST['category'];
            
            
            $formErrors = array();

            if (empty($name)){
                
                $formErrors[] = 'Name Cant Be <strong>Empty </strong>.';
                
            }
            if (empty($desc)){
                
                $formErrors[] = 'Description Cant Be <strong>Empty </strong>.';
            }
            
               if (empty($price)){
                
                $formErrors[] = 'Price Cant Be <strong>Empty </strong>.';
            }
               if (empty($country)){
                
                 $formErrors[] = 'country Cant Be<strong> Empty </strong>.';
            }
              if ($status == 0){
                
                 $formErrors[] = 'You Must Choose the<strong> Status </strong>.';
            }
            if ($member == 0){
                
                 $formErrors[] = 'You Must Choose the<strong> Member </strong>.';
            }
             if ($cat == 0){
                
                 $formErrors[] = 'You Must Choose the<strong> Category </strong>.';
            }
            if(!empty($imgName)&&!in_array($imgExt ,$imgAlwExt)){
                 $formErrors[] = 'This Extensiton is not allowed<strong> allowed </strong>.';
             }
            if(isset($imgSize) && $imgSize > 4194304 ){
                 $formErrors[] = 'This Image is too<strong> Large </strong>.';
             }
            
            foreach($formErrors as $error){
                
                echo '<div class="alrt alrtR">' . $error . '</div>' ;
            }     
                 
                 
            if(empty($formErrors)) {  
            if(empty($_FILES['itmImg']['name'])){
               
            $stmt = $con->prepare("UPDATE items SET 
                                Name = ? ,Description  = ? ,
                                Price = ? ,discount = ?, Country_Made = ? ,
                                Status = ?, Cat_ID = ? ,Member_ID=?
                                where item_ID = ?");
            $stmt->execute(array($name, $desc,$price,$disc,$country,$status,$cat,$member,$id));
            }
            else {
                $itmImg = rand(0,1000000000).'_'.$imgName;
            
                move_uploaded_file($imgTmp,'uploads\itmImgs\\'.$itmImg); 
                
                $stmt = $con->prepare("UPDATE items SET 
                                Name = ? ,Description  = ? ,Image = ?,
                                Price = ? ,discount = ?, Country_Made = ? ,
                                Status = ?, Cat_ID = ? ,Member_ID=?
                                where item_ID = ?");

                $stmt->execute(array($name, $desc,$itmImg,$price,$disc,$country,$status,$cat,$member,$id));
  
            }
            // message
            
            $msg='<div class="alrt alrtG">'. $stmt->rowCount() .' Record Updated ..</div>';
                
             redirectHome($msg ,'back',5);
            }
        }
        else {
            $errMsg ='<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            redirectHome($errMsg ,5);
        }
        
        echo '</div>';
    
    }
    
    elseif ($do == 'Delete'){ 
    
        // Delete page
        echo '<h1>Delete Item</h1>';
        echo '<div class="Konteyner_G" >';
        
           $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        
        // check userId 
        
        $check = checkItem('item_ID', 'items',$itemid);
        
        if($check > 0){
        
            $stmt = $con->prepare("delete from items where item_ID = :zitem");
            
            $stmt->bindParam(":zitem",$itemid);
            
            $stmt->execute();
            
            $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Deleted</div>';
            redirectHome($msg ,'back',5);
            
        }else {
           $errMsg= '<div class="alrt alrtR" > This ID is Not Exist</div>';
            redirectHome($errMsg ,5);
        }
        echo '</div>';
    
    }
    
    elseif ($do == 'Approve'){
        
        
        
        // approve page
        echo '<h1>Approve Item</h1>';
        echo '<div class="Konteyner_G" >';
        
           $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        
        // check itemid 
        
        $check = checkItem('item_ID', 'items',$itemid);
        
        if($check > 0){
        
            $stmt = $con->prepare("update items set Approve = 1 where item_ID = :zitem");
            
            $stmt->bindParam(":zitem",$itemid);
            
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
    header('Location: login.php');
	exit();
        }
        
    
ob_end_flush();
?>