<?php 

    include 'init.php';
    include $tpl . 'header.php';
    
    $itm = getItem($_GET['id']);
    $cmts = getComments($_GET['id']);
    
    $total = $itm[0]['1_Star']+$itm[0]['2_Star']+$itm[0]['3_Star']+$itm[0]['4_Star']+$itm[0]['5_Star'];
    for($x=1;$x<6;$x++ ){
        if($total != 0)
        $star[$x - 1] = $itm[0][$x . '_Star']/$total * 100;
        else $star[$x - 1] = 0;
        $star[$x - 1] = round($star[$x - 1],0);
    }
    $totalPercent = $itm[0]["Rating"] * 100 / 5;
    $totalPercent = round($totalPercent,0);
?>
	<link rel="stylesheet" type="text/css" href="<?php echo $css ;?>item.css">
	<div class="item-container">
		<div class="item-wrap">
			<div class="item-img">
				<div class="img-contianer">
					<img id="myImg" src="admin/uploads/itmImgs/<?php echo $itm[0]['imgName']; ?>" width="500" height="400"/>
				</div>
                <div id="myresult" class="img-zoom-result"></div>
				<div class="slider-container">
                    <label class="pre"><i class="fas fa-angle-left"></i></label>
                    <div class="imgs-cont" id="imgs-cont">
                        <?php $s = 1;
                        foreach($itm as $item){
                            if($s < 5)
                                echo '<div class="img-cont selected'.$s.'" ><img src="admin/uploads/itmImgs/' .$item['imgName']. '"></div>';
                            else
                                echo '<div class="img-cont" ><img src="admin/uploads/itmImgs/' .$item['imgName']. '"></div>';
                            $s++;
                        }?>
                    </div>
                    <label class="nxt"><i class="fas fa-angle-right"></i></label>
	           </div>
			</div>
			<div class="item-info">
				<div class="item-title">
					<strong><?PHP echo $itm[0]['Name']; ?></strong>
				</div>
				<div class="item-desc">
					<span><?PHP echo $itm[0]['Description']; ?></span>
				</div>
				<div class="item-rank">
					<span><?php echo $itm[0]["Rating"] ?></span>
				</div>
				<div class="item-price">
					<label>Fiyat:</label>
					<span><?PHP echo $itm[0]['Price']; ?> TL</span>
				</div>
				<div class="item-coupon">
					<label>Firsat:</label>
					<span><?PHP echo $itm[0]['discount']; ?> %</span>
				</div>
				<div class="shipping-info">
					<label>Firsat:</label>
					<nav class="shipping-country">Turkey</nav>
					<nav class="shipping-time">Mar 15</nav>
				</div>
				<div class="item-color">
					<label>Renk:</label>
					<span class="selected"><a href="#" >Siyah</a></span>
					<span><a href="#">Kirmizi</a></span>
				</div>
				<div class="item-count">
					<label>Adet:</label>
					<span>
						<span><i class="fas fa-minus" onclick="countPlus(2)"></i></span>
						<span><input type="text" value="1" id="item-count-input"></span>
						<span><i class="fas fa-plus" onclick="countPlus(1)"></i></span>
					</span>
				</div>
				<div class="item-btns">
					<span class="item-add-btn"><a href="#">Sepete Ekle</a></span>
					<span class="item-buy-btn"><a href="#">Hemen Satin Al</a></span>
				</div>
				<div class="item-favori">
					<span><a href="#"><i class="far fa-heart"></i> Favorilere Ekle</a></span>
				</div>
			</div>
		</div>
	</div>
	<div class="comment-container">
		<div  class="comment-wrap">
            <h2>Müşteri Yorumları</h2>
            <div class="comment-rating">
                <div class="rating">
                    <span class="rate"><?php echo $itm[0]["Rating"] ?></span>
                    <span class="rate-star">
                        <div class="stars-outer">
			             <div class="stars-inner" style ="width:<?php  echo $totalPercent . '%';?>"></div>
                        </div>
                    </span>
                </div>
                <div class="rate-statis">
                    <span class="rate-bar">
                        <span class="text">5 yildiz</span>
                        <span class="bar">
                            <span style = "width :<?php  echo $star[4] . '%';?>"></span>
                        </span>
                        <span class="count"><?php echo $itm[0]['5_Star'] ?></span>
                    </span>
                    <span class="rate-bar">
                        <span class="text">4 yildiz</span>
                        <span class="bar">
                            <span style = "width :<?php  echo $star[3] . '%';?>"></span>
                        </span>
                        <span class="count"><?php echo $itm[0]['4_Star'] ?></span>
                    </span>
                    <span class="rate-bar">
                        <span class="text">3 yildiz</span>
                        <span class="bar">
                            <span style = "width :<?php  echo $star[2] . '%';?>"></span>
                        </span>
                        <span class="count"><?php echo $itm[0]['3_Star'] ?></span>
                    </span>
                    <span class="rate-bar">
                        <span class="text">2 yildiz</span>
                        <span class="bar">
                            <span style = "width :<?php  echo $star[1] . '%';?>"></span>
                        </span>
                        <span class="count"><?php echo $itm[0]['2_Star'] ?></span>
                    </span>
                    <span class="rate-bar">
                        <span class="text">1 yildiz</span>
                        <span class="bar">
                            <span style = "width :<?php  echo $star[0] . '%';?>"></span>
                        </span>
                        <span class="count"><?php echo $itm[0]['1_Star'] ?></span>
                    </span>
                </div>
                <div class="comment-btns">
                    <span class="show-comments">
                        <a href="#">Tum yorumlar goster</a>
                    </span>
                    <span class="write-comment">
                        <a href="comment.php?id=<?php echo $_GET['id']?>">Bir yorum yaz</a>
                    </span>
                </div>
            </div>
            <div class="comment-navbar">
                <ul>
                    <li><a href="#">Hepsi</a></li>
                    <li><a href="#">Fotograflar</a></li>
                    <li><a href="#">Videolar</a></li>
                    <li class="navbar-menu">Sirala
                        <div class="comment-navbar-menu">
                            <ul>
                                <li><a href="#">Hepsi</a></li>
                                <li><a href="#">Populer</a></li>
                                <li><a href="#">Yeni</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <?php
                foreach($cmts as $cmt){
                    if(!empty($cmt['Username']))
                    $usernm = $cmt['Username'];
                    else $usernm = $cmt['Email'];
                    echo '<div class="comment-box">
                <div class="comment-name">
                    <span class="avatar"><img src="admin/uploads/avatars/'.$cmt['avatar'].'"></span>
                    <span class="name">'. $usernm  . '</span>';
                echo '</div>';
                echo '<div class="comment-rate-like">
                    <span class="rate">
                        <span class="rate-star">
                        ';
                for($i=0;$i<5;$i++){
                    if($i < $cmt['rate'])
                        echo '<i class="fas fa-star checked"></i>';
                    else echo '<i class="fas fa-star "></i>';
                }
                echo '            
                        </span>
                    </span>
                    <span class="like">
                       <a><i class="fas fa-thumbs-up"></i> Evet ('.$cmt['likes'].')</a>
                    </span>
                </div>';
                echo '<div class="comment-text">
                    <h3>'.$cmt['title'].'</h3>
                    <p>';echo $cmt['comment'].'</p>';
                    echo '<span>'.$cmt['comment_date'].'</span>';
                echo '</div>';
            echo '</div>';
                    
                }
            ?>  
        </div>
	</div>
	
<?php
    include $tpl . 'aside.php';
    include $tpl . 'footer.php';
    include $tpl . 'end.php';
?>