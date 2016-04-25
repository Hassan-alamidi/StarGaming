document.addEventListener("touchstart", function(){}, true);
var focused = document.activeElement.id;
$(document).ready(function() {
    $("#search-box").blur(function(e){
		if ( focused != '#search-submit') {setTimeout(function(){
			$("#search-submit").addClass('hide');
			$("#searchbar").css('right','0px');
		},600)
		}
      
    });
});
function show(){
	
	$("#search-submit").removeClass('hide');
	$("#searchbar").css('right','-35px');
}
