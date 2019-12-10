var i =0;
    
var slideImage = ["imgs/1.jpg","imgs/3.jpg","imgs/4.jpg","imgs/5.jpeg"];

  function slideShow(){
    document.slideshow.src = slideImage[i];
    if( i < slideImage.length - 1){
        i++;
    }else{
        i=0;
    }
    setTimeout("slideShow()",2000);
}
slideShow();

function leftSlide(){
    if(i>0)
    document.slideshow.src = slideImage[--i];
    else document.slideshow.src = slideImage[i=slideImage.length - 1];
}
function rightSlide(){
    if(i<slideImage.length - 1)
    document.slideshow.src = slideImage[++i];
    else document.slideshow.src = slideImage[i=0];
}
 
