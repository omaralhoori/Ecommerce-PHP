<?php 

ob_start();

session_start();

$pageTitle = 'Categories';

if (isset($_SESSION['Username'])){

    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    if ($do == 'Manage'){ 
    
        $sort = 'ASC';
        
        $sort_array = array('ASC','DESC');
        
        if( isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
            
            $sort = $_GET['sort'];
        }
        
        $stmt2 = $con->prepare("select * from categories order by Ordering $sort");
        
        $stmt2->execute();
        
        $cats = $stmt2->fetchAll(); ?>
        
        <h1 >Manage Categories</h1>
        <div class="Konteyner_G categories">
            <div class="pnl">
                <div class="pnl-heading"><i class="fa fa-edit"></i> Manage Categories
                    <div class="option">
                    <i class="fa fa-sort"></i> Ordering : [ 
                        <a class="<?php if($sort == 'ASC')echo 'active'; ?>" href="?sort=ASC">Asc </a>|
                        <a class="<?php if($sort == 'DESC')echo 'active'; ?>" href="?sort=DESC"> Desc</a> ]
                    <i class="fa fa-eye"></i> View : [ 
                        <span data-view="classic">Classic</span> | 
                        <span class="active" data-view="full">Full</span> ]
                    </div>
                
                </div>
                <div class="pnl-body">
                    <?php   
                        foreach($cats as $cat){
                        echo '<div class="cat">';
                            echo '<div class="hidden-buttons">';
                                echo '<a href="categories.php?do=Edit&catid='.$cat['ID'].'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                                echo '<a href="categories.php?do=Delete&catid='.$cat['ID'].'" class="confirm btn btn-xs btn-danger"><i class="fa fa-times"></i> Delete</a>';
                            echo '</div>';
                            echo '<h3>'. $cat['Name'] . '</h3>';
                            echo '<div class="full-view">';
                                echo '<p>'; if($cat['Description'] == '') {echo 'No description .';} else{echo $cat['Description'];} echo '</p>';
                                if($cat['Visibility']== 1){echo '<span class="visibility global_span"> <i class="fa fa-eye"></i> Hidden</span>';}
                                if($cat['Allow_Comment']== 1){echo '<span class="commenting global_span"><i class="fa fa-times"></i> Comment Disable</span>';}
                                if($cat['Allow_Ads']== 1){echo '<span class="advertises global_span"><i class="fa fa-times"></i> Ads Disable</span>';}
                            echo '</div>';
                        echo '</div>';
                        echo '<hr>';
                        }            
        
                        ?>
                
                </div>
            </div>
            <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
        </div>
        
<?php
     }
    
    elseif ($do == 'Add'){ 
    ?>
    
        <h1>Add New Category</h1>
        
        <div class="Konteyner_edit">
            <form action="?do=Insert" method="POST">
                <div >
                    <label class="">Name</label>
                    <div class="">
                    <input type="text" name="name" class="inputss" autocomplete="off" required="required" placeholder="Name Of The Category">
                    
                    </div>
                </div>
                <div >
                    <label class="">Description</label>
                    <div class="">      
                    <input type="text" name="description" class="inputss"  placeholder="Describe The Category">
                    </div>
                </div>
                <div >
                    <label class="">Oredering</label>
                    <div class="">
                    <input type="text" name="oredering" class="inputss" placeholder="Number To Arrange The Category">
                    
                    </div>
                </div>
                <div >
                    <label class="">Visible</label>
                    <div class="">
                        <div>
                            <input id="vis-yes" type="radio" name="visibale" value="0" checked />
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibale" value="1" />
                            <label for="vis-no">No</label>
                        </div>
                    
                    </div>
                </div>
                <div >
                    <label class="">Allow Commenting</label>
                    <div class="">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked />
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1" />
                            <label for="com-no">No</label>
                        </div>
                    
                    </div>
                </div>
                <div >
                    <label class="">Allow Ads</label>
                    <div class="">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked />
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1" />
                            <label for="ads-no">No</label>
                        </div>
                    
                    </div>
                </div>
                <div >  
                    <div class="">
                    <input type="submit" value="Add Category" class="btn_e" style="width: 100px;" >
                    
                    </div>
                </div>
            </form>
        </div>


    <?php
    }
    
    elseif ($do == 'Insert'){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<h1>Insert Category</h1>';
            echo '<div class="Konteyner_G" >'; 
            
            
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['oredering'];
            $visible = $_POST['visibale'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];
            
            
            
            
            
            // check if category exist
            
            $check = checkItem("Name","categories",$name);
            
            if($check == 1){
                
                $errMsg = '<div class="alrt alrtR">Sorry This Category Is Exist</div>';
                redirectHome($errMsg ,'back');
            }
            else{
            
            // insert user
            
              

                $stmt = $con->prepare("insert into 
                categories(Name , Description ,Ordering ,Visibility, Allow_Comment , Allow_Ads)
                values(:zname, :zdesc, :zorder, :zvisivle, :zcomment,:zads)");

                $stmt->execute(array(
                    'zname' => $name,
                    'zdesc' => $desc,
                    'zorder' => $order,
                    'zvisivle' => $visible,
                    'zcomment' => $comment,
                    'zads' => $ads
                ));


                // message

                $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Inserted</div>';
                   
                redirectHome($msg ,'back' ,6);   

                
            }
        }
        else {
            $errorMsg= '<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            
            redirectHome($errorMsg ,'back' ,6);
        }
        
        echo '</div>';
        
        
        
    }
    
    elseif ($do == 'Edit'){
        
         if( !isset($_SERVER['HTTP_REFERER'])){
            $errMsg = '<div class="alrt alrtR">You Have Come From Wrong Way ..</div> ';
            redirectHome($errMsg ,5);
        }
        
           
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        
        
        
        $stmt = $con->prepare("select *  from categories 
                where ID = ?");
	    $stmt->execute(array($catid));
        $cat = $stmt->fetch();
	    $count = $stmt->rowCount();
        if($count > 0){
        
     

?> 
        
        <h1>Edit Category</h1>
        
        <div class="Konteyner_edit">
            <form action="?do=Update" method="POST">
                <input type="hidden" name="catid" value="<?php echo $catid ?>">
                <div >
                    <label class="">Name</label>
                    <div class="">
                    <input type="text" name="name" class="inputss"  required="required" placeholder="Name Of The Category" value="<?php echo $cat['Name'];?>">
                    
                    </div>
                </div>
                <div >
                    <label class="">Description</label>
                    <div class="">      
                    <input type="text" name="description" class="inputss"  placeholder="Describe The Category" value="<?php echo $cat['Description'];?>">
                    </div>
                </div>
                <div >
                    <label class="">Oredering</label>
                    <div class="">
                    <input type="text" name="oredering" class="inputss" placeholder="Number To Arrange The Category" value="<?php echo $cat['Ordering'];?>">
                    
                    </div>
                </div>
                <div >
                    <label class="">Visible</label>
                    <div class="">
                        <div>
                            <input id="vis-yes" type="radio" name="visibale" value="0" <?php if($cat['Visibility'] == 0){echo 'checked';} ?> />
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibale" value="1" <?php if($cat['Visibility'] == 1){echo 'checked';} ?> />
                            <label for="vis-no">No</label>
                        </div>
                    
                    </div>
                </div>
                <div >
                    <label class="">Allow Commenting</label>
                    <div class="">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked <?php if($cat['Allow_Comment'] == 0){echo 'checked';} ?> />
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1){echo 'checked';} ?> />
                            <label for="com-no">No</label>
                        </div>
                    
                    </div>
                </div>
                <div >
                    <label class="">Allow Ads</label>
                    <div class="">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked <?php if($cat['Allow_Ads'] == 0){echo 'checked';} ?>/>
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1){echo 'checked';} ?>/>
                            <label for="ads-no">No</label>
                        </div>
                    
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
        
        echo '<h1>Update Category</h1>';
        echo '<div class="Konteyner_G" >';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id = $_POST['catid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['oredering'];
            $visible = $_POST['visibale'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];
        
            
        // Update
        $stmt = $con->prepare("UPDATE categories SET 
                                Name = ? ,
                                Description = ? ,
                                Ordering = ? ,
                                Visibility = ? ,
                                Allow_Comment = ? ,
                                Allow_Ads = ? 
                                where ID = ?");
        $stmt->execute(array($name,$desc ,$order ,$visible,$comment,$ads,$id));

        // message

        $msg='<div class="alrt alrtG">'. $stmt->rowCount() .' Record Updated ..</div>';

            redirectHome($msg ,'back',5);
          
        }
        else {
            $errMsg ='<div class="alrt alrtR">Sorry you cant browse this page directly</div>';
            redirectHome($errMsg ,5);
        }
        
        echo '</div>';
    }
    
    elseif ($do == 'Delete'){   

        
        // Delete page
        echo '<h1>Delete Category</h1>';
        echo '<div class="Konteyner_G" >';
        
           $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        
        // check ID 
        
        $check = checkItem('ID', 'categories',$catid);
        
        if($check > 0){
        
            $stmt = $con->prepare("delete from categories where ID = :zid");
            
            $stmt->bindParam(":zid",$catid);
            
            $stmt->execute();
            
            $msg= '<div class="alrt alrtG">' . $stmt->rowCount() . ' Record Deleted</div>';
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