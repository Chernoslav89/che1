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

	$('.dropMenu').on('click', function(){
		$(this).next('.podMenu').slideToggle(400);
	});
//================ END POPUP WINDOW FOR LOG IN

})
