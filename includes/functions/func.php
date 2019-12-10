<?php
    /*    get Categories   */

        function getCat(){
        
        global $con;
        
        $getCat = $con->prepare("select * from categories order by ID asc");
        
        $getCat->execute();
        
        $cats = $getCat->fetchAll();
        
        return $cats;
    }


/*    get items   */

        function getItems(){
        
        global $con;
        
        $getItem = $con->prepare("select * from items where Approve!=0 order by item_ID asc");
        
        $getItem->execute();
        
        $item = $getItem->fetchAll();
        
        return $item;
    }
/*    get item info   */

        function getItem($itemID){
        
        global $con;
        
        $getItem = $con->prepare("select * from items join imgs_item on items.item_ID = imgs_item.itemID  where item_ID = ?");
        
        $getItem->execute(array($itemID));
        
        $item = $getItem->fetchAll();
        
        return $item;
    }
/*           get Comment for items                 */
 function getComments($itemID){
        
        global $con;
        
        $getItem = $con->prepare("select * from comments join users on comments.user_ID=users.UserID  where item_ID = ?");
        
        $getItem->execute(array($itemID));
        
        $comment = $getItem->fetchAll();
        
        return $comment;
    }

    /* page title  */
    
    function getTitle(){
        
        global $pageTitle;
        
        if (isset($pageTitle)){
            echo $pageTitle;
        }
        else{
            echo 'Default';
        }
    }



/*   redirect func                  */

    function redirectHome($errorMsg, $url = null ,$seconds = 3){
        
        if ($url === null){
            
            $url = 'login.php';
            $link = 'Home Page';
            
        } else{
            
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){
            
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
                
            }else {
                $url= 'login.php';
                $link = 'Home Page';
            }
        }
        
        
        echo "<div class='Konteyner_G'> $errorMsg";
        
        echo "<div class='alrt alrtI'>You Will Redirected to $link After $seconds Seconds.</div></div>";
        
        header("refresh:$seconds;url=$url");
        
        exit();
    }

/*            signup */
function redirectActive($Msg, $url ='active.php' ,$seconds = 3){
        
            $link = 'Activation Page';
        
        echo "<div class='Konteyner_G'> $Msg";
        
        echo "<div class='alrt alrtI'>You Will Redirected to $link After $seconds Seconds.</div></div>";
        
        header("refresh:$seconds;url=$url");
        
        exit();
    }





/*              check in Database         */

    function checkItem($select, $from , $value){
        
        global $con;
        
        $statement = $con->prepare("select $select from $from where $select = ?");
        
        $statement->execute(array($value));
        
        $count = $statement->rowCount();
        
        return $count;
    }

/*           check numbers of items      */

    function countItems($item, $table){
        global $con;
        
        $stmt2 = $con->prepare("select count($item) from $table");
    
        $stmt2->execute();
    
        return $stmt2->fetchColumn();
        
    }

/*     get lateset records    */

    function getLatest($select,$table,$order,$limit = 5){
        
        global $con;
        
        $getStmt = $con->prepare("select $select from $table order by $order desc limit $limit");
        
        $getStmt->execute();
        
        $rows = $getStmt->fetchAll();
        
        return $rows;
    }