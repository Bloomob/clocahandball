$(document).ready(function() {
	appelCorps('accueil');
	
	$("header a.menu-bouton").click( function() {
		if($("#menu_principal").length == 0) {
			$("#corps").fadeOut('500');
			$.ajax({
				type: "POST",
				url: "inc/ajax_menu.php",
				success: function(data) {
					$('#corps').html(data).fadeIn('500');
				}
			});
		}
		else {
			$('header a.prev-bouton').hide();
			$("#corps").fadeOut('500');
			appelCorps($("#page_actuelle").val());
		}
		return false; 
	});
	
	$("header a.prev-bouton").click( function() {
		$('header a.prev-bouton').hide();
		if($("#menu_principal").length != 0) {
			$('.sous-menu').hide("slide", { direction: "right" }, 500);
			$('#menu_principal').show("slide", { direction: "left" }, 500);
		}
		return false;
	});
	
	$("footer li").click( function() {
		if(!$(this).hasClass("active")){
			$("footer li").removeClass("active");
			if($( event.target ).is( '#barre-menu-1' )) {
				$(this).addClass("active");
				$("#corps").fadeOut('500');
				appelCorps('accueil');
			}
			else if($( event.target ).is( '#barre-menu-2' )) {
				$(this).addClass("active");
				$("#corps").fadeOut('500');
				appelCorps('breves');
			}
			else if($( event.target ).is( '#barre-menu-3' )) {
				$(this).addClass("active");
			}
			else if($( event.target ).is( '#barre-menu-4' )) {
				$(this).addClass("active");
			}
		}
	});
});

function appelCorps(page) {
	$.ajax({
		type: "POST",
		url: "inc/ajax_"+ page +".php",
		success: function(data) {
			$('#corps').html(data).fadeIn('500');
			$('#page_actuelle').val(page);
		}
	});
}

function appelSousMenu(menu) {
	$('#menu_principal').hide("slide", { direction: "left" }, 500);
	$('#'+ menu).show("slide", { direction: "right" }, 500);
	$('header a.prev-bouton').show();
}

function appelNews(id_breve) {
	$.ajax({
		type: "POST",
		url: "inc/ajax_uneBreve.php",
		data: { id: id_breve },
		success: function(data) {
			$('#liste_breves').hide("slide", { direction: "left" }, 500);
			$('#une_breve').html(data).show("slide", { direction: "right" }, 500);
			$('header a.prev-bouton').show();
			
		}
	});
	$('#page_actuelle').val("breves");
}