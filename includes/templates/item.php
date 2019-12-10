<div class="tml-item">
    <?php 
    $itm = getItem($item['item_ID']);
    ?>
    <div class="item-img">
        <a href="item.php?id=<?php echo $item['item_ID'] ?>"><img src="admin/uploads/itmImgs/<?php echo $itm[0]['imgName']; ?>" alt = "no image"></a>
    </div>
    <?php 
        if(!empty($item['discount']))
        echo '<div class="item-discount">
            <i class="fas fa-circle"></i><span>%'.$item['discount'].' OFF</span>
        </div>'; 
    ?>
    <div class="item-title">
        <span><?php echo '<a href="item.php?id='.$item['item_ID'].'">'. $item['Name'] .'</a>'; ?></span>
    </div>
    <?php 
        if(!empty($item['discount']))
        echo '
        <div class="item-oldprice">
            <span class="priceNum">'.$item['Price'].' </span><span class="currency">TL</span>
        </div>'; 
    ?>
        
    <div class="item-newprice">
        <span class="priceNum">
            <?php 
                if(empty($item['discount']))
                    echo $item['Price']; 
                else {
                    @$disco = $item['Price']-($item['Price']*$item['discount']/100);
                    echo $disco;} 
            ?>
        </span>
        <span class="currency"> TL</span>
    </div>
    <div class="item-like">
        <i class="far fa-heart"></i>
    </div>
</div>