/*
|--------------------------------------------------------------------------
| POPUP data-width="600" data-height="800" rel="1" id="pop_1" class="newWindow"
|--------------------------------------------------------------------------
*/
jQuery(document).ready(function($){
var scrollBArray = [ "scrollbars=no",  /* rel="0" */
                     "scrollbars=yes" /* rel="1" */
                   ];
$('.newWindow').click(function (event){
var url = $(this).attr("href");
var w1 = $(this).attr("data-width"), h1 = $(this).attr("data-height");
var left  = ($(window).width()/2)-(w1/2),
    top   = ($(window).height()/2)-(h1/2);
var windowName = $(this).attr("id");
var scrollB = scrollBArray[$(this).attr("rel")];
window.open(url, windowName,"width="+w1+", height="+h1+", top="+top+", left="+left+", "+scrollB);
event.preventDefault();
      });
});

