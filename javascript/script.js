$(function(){

	// Logo
	$("#logo").click( function() {
		document.location.href = "index.php";
	});

	// Pour l'export des matchs à venir

	$('#export_cal').click(function() {
		$.ajax({
			type: "POST",
			url: "inc/ajax/export_cal.php",
			success: function(data) {
				var maDiv = $( "#maDiv" ).html(data);
				maDiv.dialog({
					title: "Exporter le calendrier en format texte",
					draggable: false,
					resizable: false,
					width: 650,
					height: 450,
					modal: true
				});
			}
		});
	});


	// Pour que le menu soit accessible même quand on bottom scroll
	
	$(window).scroll( function(){
		if(window.pageYOffset > 118) {
			$('#page1 header').addClass('top');
		}
		else {
			$('#page1 header').removeClass('top');
		}
	});

	// Pour le menu en version mobile

	if(isMobile()){
		$('#slogan').click(function(){
			$('body').toggleClass('menu_open');
			return false;
		});
	}

	$('input.numeric').keyup(function(){
		console.log('keyup');
		var reg = new RegExp('^[0-9]?$', 'g');
		if(!$(this).val().match(reg))
			$(this).css('border', '2px solid #5CB85C');
		else
			$(this).css('border', '2px solid #d9534f');
	});

	window.setInterval(sliderPhoto, 5000);
});

function sliderPhoto() {
	var photoActive = $(".phototheque .unePhoto.actif").hide("fade", "slow").removeClass('actif');
	var photoSuiv = photoActive.next();
	if(photoSuiv.length > 0)
		photoSuiv.show("fade", "slow").addClass('actif');
	else
		$(".phototheque .unePhoto").first().show("fade", "slow").addClass('actif');
}

function isMobile() {
	if( $( window ).width() < 768 )
	 	return true;
	else
		return false;
}