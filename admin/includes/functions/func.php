<?php

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


/*              check in Database         */

    function checkItem($select, $from , $value){
        
        global $con;
        
        $statement = $con->prepare("select $select from $from where $select = ?");
        
        $statement->execute(array($value));
        
        $count = $statement->rowCount();
        
        return $count;
    }
/*              get select         */

    function getSelect($select, $from , $column , $value){
        
        global $con;
        
        $statement = $con->prepare("select $select from $from where $column = ?");
        
        $statement->execute(array($value));
        
        $item = $statement->fetchAll();
        
        return $item;
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