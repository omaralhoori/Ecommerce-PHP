$(function (){
    
	'use strict';
    
    //Dashboard
    
    $('.toggle-info').click(function(){
        
        $(this).toggleClass('selected').parent().next('.pnl-body').fadeToggle(100);
        
        if($(this).hasClass('selected')){
            $(this).html("<i class='fa fa-minus'></i>");
                                }
        else  $(this).html("<i class='fa fa-plus'></i>");
    });
    

	//Hide PlaceHolder on Focus

    

	$('[placeholder]').focus(function(){

		$(this).attr('data-text' , $(this).attr('placeholder'));

		$(this).attr('placeholder', '');


	}).blur(function(){

		$(this).attr('placeholder',$(this).attr('data-text'));
	});
		


   // -----func
    
    	var deg=0;
    
    $(".hesap_isim").hover(function(){
    if (deg==0){
          $(this).css("background-color","#00a8ff");     
      }
      },function(){
        if (deg==0)
          $(this).css("background-color","transparent");                    });  
   
    
   $(".hesap_isim").click(function(){
       if (deg==180){deg-=180; }
       else {
       	deg+=180;
       	$(this).css({
       	"background-color" : "#00a8ff"
       });
       }
       
   $(".drop_menu").slideToggle(500);
       $(".hesap_isim i").css("transform","rotate("+deg+"deg)");
}); 
  
//   required field   
    
    $('input').each(function(){
       
        if ($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk">*</span>')
        }
    });

// password show
    
    var passField = $('.password');
    
    $('.show-pass').hover(function(){
        
        passField.attr('type' ,'text');
    } , function(){
        passField.attr('type' ,'password');
        
    });
    
//  Confirmation Message
    
    $('.confirm').click(function(){
        
        return confirm('Are you sure');
    });
// Category View Option
    $('.cat h3').click(function(){
        
        $(this).next('.full-view').fadeToggle(200);
    });
    
    $('.option span').click(function(){
        $(this).addClass('active').siblings('span').removeClass();
        
        if($(this).data('view')==='full'){
            
            $('.cat .full-view').fadeIn(200);
        }else {
            $('.cat .full-view').fadeOut(200);
        }
        
    });
}

);

function slideNav(){
    $(".konteyner_menu,.hesap").slideToggle(500);
}

            