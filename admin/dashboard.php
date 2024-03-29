<?php 
    
    ob_start();

    session_start();

if(isset($_SESSION['Username'])){
    $pageTitle = 'Dashboard';
    
    include 'init.php';
    
    $numUsers = 5; 
    $latestUsers = getLatest('*','users','UserID',$numUsers);
    $numItems = 5; 
    $latestItems = getLatest('*','items','item_ID',$numItems);
    $numComments = 5;
    ?>
    
    <div class="Konteyner_G home-stats">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    <i class="fa fa-users"></i>
                    <div class="info">
                        Total Members
                    <span><a href="members.php"><?php echo countItems('UserID','users')?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    <i class="fa fa-user-plus"></i>
                    <div class="info">
                        Pending Members
                <span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0); ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    <i class="fa fa-tag"></i>
                    <div class="info">
                    Total Items
                <span><a href="items.php"><?php echo countItems('item_ID','items')?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    <i class="fa fa-comments"></i>
                    <div class="info">
                        Total Comments
                <span><a href="comments.php"><?php echo countItems('C_ID','comments')?></a></span>
                    </div>
                </div>
            </div>
        
        </div>
    </div>

    <div class="Konteyner_G latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="pnl">
                    <?php 
    
                    ?>
                    <div class="pnl-heading">
                        <i class="fa fa-users"></i> Latest <?php echo $numUsers; ?> Registerd Users
                        <span class="toggle-info">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="pnl-body">
                        <ul class="latest-users">
                        <?php 
                           
                            foreach ($latestUsers as $user){

                                echo  '<li>'; 
                                    echo $user['Username'];
                                    echo '<a href="members.php?do=Edit&userid='.$user['UserID'].'">';
                                        echo '<span class="btn btn-success btnUser">';
                                            echo '<i class=" fa fa-edit"></i> Edit';
                                            if($user['RegStatus'] == 0){
                                        echo ' <a href="members.php?do=Activate&userid='. $user['UserID'] . '" class="btn btn-info btnUser"><i class="fas fa-plus"></i> Activate</a> ';
                                                }
                                        echo '</span>';
                                    echo '</a>';
                                echo '</li>';
                        
                                                }
                        
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="pnl">        
                    <div class="pnl-heading">
                        <i class="fa fa-tag"></i> Latest <?php echo $numItems; ?> Items
                        <span class="toggle-info">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="pnl-body">
                        <ul class="latest-users">
                        <?php 
                           
                            foreach ($latestItems as $item){

                                echo  '<li>'; 
                                    echo $item['Name'];
                                    echo '<a href="items.php?do=Edit&itemid='.$item['item_ID'].'">';
                                        echo '<span class="btn btn-success btnUser">';
                                            echo '<i class=" fa fa-edit"></i> Edit';
                                            if($item['Approve'] == 0){
                                        echo ' <a href="items.php?do=Approve&itemid='. $item['item_ID'] . '" class="btn btn-info btnUser"><i class="fas fa-plus"></i> Approve</a> ';
                                                }
                                        echo '</span>';
                                    echo '</a>';
                                echo '</li>';
                        
                                                }
                        
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="pnl">
                    <?php 
    
                    ?>
                    <div class="pnl-heading">
                        <i class="fa fa-comments"></i> Latest <?php echo $numComments; ?> Comments
                        <span class="toggle-info">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="pnl-body">
                    <?php
                        $stmt = $con->prepare("select comments.*,users.Username as user
                            from comments inner join
                            users on users.UserID = comments.user_ID order by C_ID desc limit $numComments ");      
                        $stmt->execute();

                        $comments = $stmt->fetchAll();
    
                        foreach($comments as $comment){
                            
                            echo '<div class="comment-box">';
                                echo '<span class="member-n">' . $comment['user'] . '</span>';
                                echo '<p class="member-c">' . $comment['comment'] . '</p>';
                            echo '</div>';
                        }
                        
                    ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    include $tpl . 'footer.php';
}
else {
	header('Location: login.php');
	//echo "<script> window.location.replace('login.php') </script>";
	exit();
}

    ob_end_flush();

?>