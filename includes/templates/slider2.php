<div class="sli2_cont">
<div class="slider2">
    <?php $items = getItems(); ?>
    <div class="first">
        <div class="mainDiv"><?php $item = $items[0]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[1]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[2]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[3]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[4]; include  $tpl . 'item.php'; ?></div>
    </div>
    <div class="second">
        <div class="mainDiv"><?php $item = $items[5]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[6]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[2]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[3]; include  $tpl . 'item.php'; ?></div>
        <div class="sideDiv"><?php $item = $items[4]; include  $tpl . 'item.php'; ?></div>
    </div>
    <div class="left-slide">
        <i class="fas fa-angle-left"></i>
    </div>
    <div class="right-slide">
        <i class="fas fa-angle-right"></i>
    </div>
</div>
</div>
<script >
var currentSlide = 1 ;
var slider = $(".slider2");
var slideCount = slider.children().length;
var slideTime = 4000;
var animationTime = 2000;
var slideFunc=function(){
    if(currentSlide == 0)$('.first').css("left" , "-1300px");
    else $('.second').css("left" , "-1300px");
    $('.first').animate({
        left : '+=1300px'
    }, animationTime , function(){
        currentSlide++;
    if(currentSlide > 1){    
    $(this).css("left" , "-1300px");
        currentSlide = 0 ;
    }
    });
    $('.second').animate({
        left : '+=1300px'
    }, animationTime , function(){
        
    if(currentSlide == 1)   
    $(this).css("left" , "-1300px");       
    });

}
var slied = setInterval(slideFunc,slideTime);
$('.sli2_cont').hover(function(){
    clearInterval(slied);
},function(){
    slied = setInterval(slideFunc,slideTime);
});
$('.right-slide').click(function(){
    if(currentSlide == 0)$('.first').css("left" , "-1300px");
    else $('.second').css("left" , "-1300px");
    $('.first').animate({
        left : '+=1300px'
    }, animationTime , function(){
        currentSlide++;
    if(currentSlide > 1){    
    $(this).css("left" , "-1300px");
        currentSlide = 0 ;
    }
    });
    $('.second').animate({
        left : '+=1300px'
    }, animationTime , function(){
        
    if(currentSlide == 1)   
    $(this).css("left" , "-1300px");       
    });
});
$('.left-slide').click(function(){
    if(currentSlide == 0)$('.first').css("left" , "1300px");
    else $('.second').css("left" , "1300px");
    $('.first').animate({
        left : '-=1300px'
    }, animationTime , function(){
        currentSlide++;
    if(currentSlide > 1){    
    $(this).css("left" , "+1300px");
        currentSlide = 0 ;
    }
    });
    $('.second').animate({
        left : '-=1300px'
    }, animationTime , function(){
        
    if(currentSlide == 1)   
    $(this).css("left" , "+1300px");       
    });
});
</script>