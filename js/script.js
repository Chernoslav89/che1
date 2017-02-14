$(function() {

//================= POPUP WINDOW FOR LOG IN
	$('.logIn').on('click', function() {
		$('.bgOpacity').show(300);
		$('.popupLogIn').slideToggle(300);
	});
	$('.bgOpacity').on('click', function(){
		$(this).hide();
		$('.popupLogIn').slideUp(300);
	});
//================ END POPUP WINDOW FOR LOG IN

})
