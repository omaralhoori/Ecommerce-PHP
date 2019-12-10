function imageZoom(imgID, resultID) {
  var img, lens, result, cx, cy;
  img = document.getElementById(imgID);
  result = document.getElementById(resultID);
  /*create lens:*/
  lens = document.createElement("DIV");
  lens.setAttribute("id", "img-zoom-lens");
  /*insert lens:*/
  img.parentElement.insertBefore(lens, img);
  /*calculate the ratio between result DIV and lens:*/
  cx = result.offsetWidth / lens.offsetWidth;
  cy = result.offsetHeight / lens.offsetHeight;
  /*set background properties for the result DIV:*/
  result.style.backgroundImage = "url('" + img.src + "')";
  result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
  /*execute a function when someone moves the cursor over the image, or the lens:*/
  lens.addEventListener("mousemove", moveLens);
  img.addEventListener("mousemove", moveLens);
  /*and also for touch screens:*/
  lens.addEventListener("touchmove", moveLens);
  img.addEventListener("touchmove", moveLens);
  function moveLens(e) {
    var pos, x, y;
    /*prevent any other actions that may occur when moving over the image:*/
    e.preventDefault();
    /*get the cursor's x and y positions:*/
    pos = getCursorPos(e);
    /*calculate the position of the lens:*/
    x = pos.x - (lens.offsetWidth / 2);
    y = pos.y - (lens.offsetHeight / 2);
    /*prevent the lens from being positioned outside the image:*/
    if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
    if (x < 0) {x = 0;}
    if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
    if (y < 0) {y = 0;}
    /*set the position of the lens:*/
    lens.style.left = x + "px";
    lens.style.top = y + "px";
    /*display what the lens "sees":*/
    result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
  }
  function getCursorPos(e) {
    var a, x = 0, y = 0;
    e = e || window.event;
    /*get the x and y positions of the image:*/
    a = img.getBoundingClientRect();
    /*calculate the cursor's x and y coordinates, relative to the image:*/
    x = e.pageX - a.left;
    y = e.pageY - a.top;
    /*consider any page scrolling:*/
    x = x - window.pageXOffset;
    y = y - window.pageYOffset;
    return {x : x, y : y};
  }
}


$(document).ready(function(){
    var deg=0;
$(".kategori_H").click(function(){
       if(deg==180){deg-=180; }
       else deg+=180;
   $(".kate_list").slideToggle(500);
       $(".trans").css("transform","rotate("+deg+"deg)");
}); 
    
$(".uyuluk_H_div").hover(function(){
    
    $(".uyuluk_H_Box").toggle();
}); 
    
$(".sepet_H_div").hover(function(){
    
    $(".sepet_H_Box").toggle();
});
    
$(".kate_list li").click(function(){
    if(deg==180){deg-=180;}
    else deg+=180;
    $(".kategori_m").text(($(this).text()));
    $(".kate_list").slideToggle(500);
    $(".trans").css("transform","rotate("+deg+"deg)")
});   
                             
$(window).scroll(function(){
    var scroll= $(this).scrollTop();
    if( scroll > 200){
        $('.aside-menu').show();
    }else{
        $('.aside-menu').hide();
    }
});
                            
$('.aside-menu .as-arrow').click(function(){
    $('html ,body').animate({
        scrollTop : $('header').offset().top
    },1000);
});
/*   item  slider         */
var select = 0;
var maxSelect = document.getElementById('imgs-cont').childElementCount;
if(maxSelect < 5) $('.slider-container .nxt').css('color','#999');
$('.slider-container .pre').click(function(){
			
			if(select > 0){
				$('.selected4').removeClass('selected4').prev().removeClass('selected3').addClass('selected4').prev().removeClass('selected2').addClass('selected3').prev().removeClass('selected1').addClass('selected2').prev().removeClass('selected0').addClass('selected1');
				select--;
                if(select == 0 )$(this).css('color','#999');
                if(select == maxSelect - 5)$('.slider-container .nxt').css('color','#000');
			}
		});
$('.slider-container .nxt').click(function(){
			if(select < maxSelect - 4){
				$('.selected1').removeClass('selected1').addClass('selected0').next().removeClass('selected2').addClass('selected1').next().removeClass('selected3').addClass('selected2').next().removeClass('selected4').addClass('selected3').next().addClass('selected4');
				select++;
                if(select == maxSelect - 4)$(this).css('color','#999');
                if(select == 1)$('.slider-container .pre').css('color','#000');
			}
		});
$('.item-img .img-cont').hover(function(){
    document.getElementById("myImg").src = $(this).children(':first').attr('src');    
});
 /*      img zoom    */                            
$('.img-contianer').hover(function(){
	$('#myresult').css('display','block');	
    imageZoom("myImg", "myresult");
    
		
		},
                          function(){
			$('#img-zoom-lens').remove();
			$('#myresult').css('backgroundImage','');
            $('#myresult').css('display','none');
		  });

});
function countPlus(s){
    var input = document.getElementById('item-count-input');
    var amount = input.value;
    
    if(s == 1){
        amount++;
        input.value = amount;
    }else if(s == 2 && amount != 0){
        amount--;
        input.value = amount;
    }
    
}