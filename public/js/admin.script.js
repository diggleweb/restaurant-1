$(document).ready(function(){
	resizeDiv();
});

window.onresize = function(event) {
	resizeDiv();
}

function resizeDiv() {
	vph = $(window).height();
	// $('#admin-container >.container-fluid').css({'min-height': vph + 'px'});
}