<?php 
    
ob_start();

session_start();

$pageTitle = 'Comment';

if(isset($_SESSION['Email'])){
    include 'init.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
         $stmt = $con->prepare("insert into  
        comments(title,comment,rate,comment_date,item_ID,user_ID)
        values(?,?,?,now(),?,?)");
	    $stmt->execute(array(
            $_POST['title'],$_POST['comment'],
            $_POST['rate'],$_POST['itmid'], 
            $_SESSION['UserID']));
        
        $rate = $_POST['rate'].'_Star';
        $ttlRating = ($_POST['total'] * $_POST['rating'] + $_POST['rate'] )/($_POST['total'] + 1);
        $ttlRating = round($ttlRating,1);
        $stars = explode(',',$_POST['stars']);
        if($_POST['rate'] == 1){
            $stmt2 = $con->prepare("update items set 1_Star= ? + 1, Rating = ? where item_ID = ?");}
        else if($_POST['rate'] == 2){
            $stmt2 = $con->prepare("update items set 2_Star= ? + 1, Rating = ? where item_ID = ?");}
        else if($_POST['rate'] == 3){
            $stmt2 = $con->prepare("update items set 3_Star= ? + 1, Rating = ? where item_ID = ?");}
        else if($_POST['rate'] == 4){
            $stmt2 = $con->prepare("update items set 4_Star= ? + 1, Rating = ? where item_ID = ?");}
        else if($_POST['rate'] == 5){
            $stmt2 = $con->prepare("update items set 5_Star= ? + 1, Rating = ? where item_ID = ?");}
        $stmt2->execute(array($stars[$_POST['rate'] - 1],$ttlRating ,$_POST['itmid']));
        $msg= '<div class="alrt alrtG">  Comment has been sent</div>';
                   
        redirectHome($msg ,'back' ,2); 

}else{
    include $tpl . 'header.php';
    $itm = getItem($_GET['id']);
    $total = $itm[0]['1_Star']+$itm[0]['2_Star']+$itm[0]['3_Star']+$itm[0]['4_Star']+$itm[0]['5_Star'];
    $stars = '';    
    for($x=1;$x<6;$x++ ){
        $stars .= $itm[0][$x . '_Star'] . ',';
        if($total != 0)
        $star[$x - 1] = $itm[0][$x . '_Star']/$total * 100;
        else $star[$x - 1] = 0;
        $star[$x - 1] = round($star[$x - 1],0);
    }
    $totalPercent = $itm[0]["Rating"] * 100 / 5;
    $totalPercent = round($totalPercent,0);
?>
<div class="comment-page-container">
    <div class="item-title">
        <strong><?PHP echo $itm[0]['Name']; ?></strong>
    </div>
    <div class="item-info">
        <div class="img-contianer">
					<a href="item.php?id=<?php echo $_GET['id'] ?>"><img id="myImg" src="admin/uploads/itmImgs/<?php echo $itm[0]['imgName']; ?>" width="300" height="300"/></a>
        </div>
        <div class="item-rating-stars">
            <div class="rate">
                <span class="stars">
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                </span>
                <strong>Çok İyi</strong>
                <span class="rate-no">(<?php echo $itm[0]['5_Star'] ?>)</span>
            </div>
            <div class="rate">
                <span class="stars">
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star "></i>
                </span>
                <strong>İyi</strong>
                <span class="rate-no">(<?php echo $itm[0]['4_Star'] ?>)</span>
            </div><div class="rate">
                <span class="stars">
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star "></i>
                    <i class="fas fa-star "></i>
                </span>
                <strong>Ne İyi/Ne Kötü</strong>
                <span class="rate-no">(<?php echo $itm[0]['3_Star'] ?>)</span>
            </div><div class="rate">
                <span class="stars">
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star "></i>
                    <i class="fas fa-star "></i>
                    <i class="fas fa-star "></i>
                </span>
                <strong>Kötü</strong>
                <span class="rate-no">(<?php echo $itm[0]['2_Star'] ?>)</span>
            </div><div class="rate">
                <span class="stars">
                    <i class="fas fa-star checked"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </span>
                <strong>Çok Kötü</strong>
                <span class="rate-no">(<?php echo $itm[0]['1_Star'] ?>)</span>
            </div>
        </div>
        <div class="item-rating-bars">
            <div class="rate-bar">
                <span class="empty-bar"><span class="full-bar" style = "width :<?php  echo $star[4] . '%';?>"></span></span>
                <span class="rate-percentage"><?php  echo $star[4] . '%';?></span>
            </div>
            <div class="rate-bar">
                <span class="empty-bar"><span class="full-bar" style ="width :<?php  echo $star[3] . '%';?>"></span></span>
                <span class="rate-percentage"><?php  echo $star[3] . '%';?></span>
            </div>
            <div class="rate-bar">
                <span class="empty-bar"><span class="full-bar" style ="width:<?php  echo $star[2] . '%';?>"></span></span>
                <span class="rate-percentage"><?php  echo $star[2] . '%';?></span>
            </div>
            <div class="rate-bar">
                <span class="empty-bar"><span class="full-bar" style ="width:<?php  echo $star[1] . '%';?>"></span></span>
                <span class="rate-percentage"><?php  echo $star[1] . '%';?></span>
            </div>
            <div class="rate-bar">
                <span class="empty-bar"><span class="full-bar" style ="width:<?php  echo $star[0] . '%';?>"></span></span>
                <span class="rate-percentage"><?php  echo $star[0] . '%';?></span>
            </div>
            
        </div>
        <div class="item-rating-total">
            <div class="talk-bubble">
                <div class="total-stars">
                    <div class="stars-outer">
			             <div class="stars-inner" style ="width:<?php  echo $totalPercent . '%';?>"></div>
                    </div>
                </div>
                <div class="total-rating"><?php echo $itm[0]['Rating']?></div>
            </div>
        </div>
    </div>
    <div class="comment-form">
        <form id="comment-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h3>Yorum Yap</h3>
            <div class="rating-form">
                <span class="rate-label">Urune Puan Verin</span>
                <span class="rate-stars">
                    <input type="hidden" name="total" value="<?php echo $total?>">
                    <input type="hidden" name="rating" value="<?php echo $itm[0]['Rating']?>">
                    <input type="hidden" name="rate" value="1" id="id-rating">
                    <input type="hidden" name="itmid" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name="stars" value="<?php echo $stars ?>">
                    <div id="list">
                        <i class="fas fa-star star-bos"></i>
                        <i class="fas fa-star star-bos"></i>
                        <i class="fas fa-star star-bos"></i>
                        <i class="fas fa-star star-bos"></i>
                        <i class="fas fa-star star-bos"></i>
                    </div>
                </span>
                <span class="rate-desc"></span>
            </div>
            <div class="commenting-form">
                <input type="text" name="title" placeholder="Yorum Basligi" ><br>
                <textarea form="comment-form" name="comment" placeholder="Yorum"></textarea><br>
                <input type="submit" value="Gonder">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    
var nodes =  Array.prototype.slice.call( document.getElementById('list').children );
var stars = document.getElementsByClassName('star-bos');
var hiddenText = document.getElementsByClassName('rate-desc')[0];
var ratingArray = Array('cok kotu' ,'kotu','ne iyi ne kotu' ,'iyi','cok iyi' );
var ss = -1;
for (let star in stars){
    if(star < 5){
    stars[star].addEventListener("mouseover", selectStar);
    stars[star].addEventListener("mouseout", deSelectStar);
    stars[star].addEventListener("click", clickStar);
    }
}
function selectStar(e){
    var hoveredStar = e.target;
    for (var i = 0; i <= nodes.indexOf(hoveredStar); i++) {
        stars[i].style.color = "#ff8a00";
    }
}
function deSelectStar(e){
    var hoveredStar = e.target;

    for (var i = ss + 1; i < 5; i++) {
        stars[i].style.color = "#ddd";
    }
}
function clickStar(e){
    ss= nodes.indexOf(e.target);
    document.getElementById('id-rating').value = ss + 1;
    hiddenText.innerHTML = ratingArray[ss];
}

</script>
<?php
    include $tpl . 'aside.php';
    include $tpl . 'footer.php';
    include $tpl . 'end.php';
}
}else{
    header('Location: login.php');
}


?>