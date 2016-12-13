$(function(){
	$("#logo").click( function() {
		document.location.href = "index.php";
	});
	if(!isMobile()) {
		$("#navbar").mouseleave(function() {
			$(".sous_menu").slideUp("fast");
		});
	
		$("#navbar > ul > li").each(function() {
			var id_navbar = $(this).attr("id")
			var id = id_navbar.split(new RegExp("navbar-item-", "g"));

			$(this).mouseover( function() {
				$(".sous_menu").slideUp("fast");
				if($("#navbar-subnav-"+id[1])){
					var left = this.offsetLeft;
					$("#navbar-subnav-"+id[1]).slideDown("fast").css("left", left+"px");
				}
			});
		});

		id = 1;
		if($(".gallery1").length > 0 && !isMobile())
			window.setInterval(sliderAuto, 8000);

		$(".gallery1 a").click(function() {	
			var largePath = $(this).attr("href");
			location.href = "actualites.php?id="+largePath;
			return false;
	    });

		$(".gallery1 ul li a").click(function() {
			var imgId = $(this).attr("id");

			var grdImgSource = $("#grandeImage .large_image").attr("src");
			var titreGrandeNews = $(".gallery1 dt .legende_actualite .titre_first").text();
			var sousTitreGrandeNews = $(".gallery1 dt .legende_actualite .sous_titre_first").text();
			var themeGrandeNews = $(".gallery1 dt .theme_actualite").text();	
			var idGrandeNews = $("#grandeImage").attr("href");

			var idPetiteNews = $('#'+ imgId).attr("href");
			var imgPetiteNews = $('#'+ imgId +' span span img').attr("src");
			var titrePetiteNews = $('#'+ imgId +' span span .titre_mini').text();
			var sousTitrePetiteNews = $('#'+ imgId +' span span .sous_titre_mini').text();
			var themePetiteNews = $('#'+ imgId +' span span .theme_mini').text();
			
			$(".gallery1 dt").animate({ opacity: "0" }, "middle", function(){
				$("#grandeImage .large_image").attr({ src: imgPetiteNews});
				$("#grandeImage").attr("href", idPetiteNews);
				$(".gallery1 dt .legende_actualite .titre_first").text(titrePetiteNews);
				$(".gallery1 dt .legende_actualite .sous_titre_first").text(sousTitrePetiteNews);
				$(".gallery1 dt .theme_actualite").text(themePetiteNews);

				$('#'+ imgId +' span span img').attr("src", grdImgSource);
				$('#'+ imgId).attr("href", idGrandeNews);
				$('#'+ imgId +' span span .titre_mini').text(titreGrandeNews);
				$('#'+ imgId +' span span .sous_titre_mini').text(sousTitreGrandeNews);
				$('#'+ imgId +' span span .theme_mini').text(themeGrandeNews);
			});
			$(".gallery1 dt").animate({ opacity: "1" }, "slow");
			
			return false;
	    });

		

		$(".tab_content").hide(); //Hide all content
		$("ul.tabs li:first").addClass("active").show(); //Activate first tab
		$(".tab_content:first").show(); //Show first tab content
		
		$("ul.tabs li").click(function() {
			$("ul.tabs li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_content").hide(); //Hide all tab content
		
			var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active ID content
			return false;
		});

		$(".tab_content2").hide(); //Hide all content
		$("ul.tabs2 li:first").addClass("active").show(); //Activate first tab
		$(".tab_content2:first").show(); //Show first tab content
		
		$("ul.tabs2 li").click(function() {
			$("ul.tabs2 li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_content2").hide(); //Hide all tab content
		
			var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active ID content
			return false;
		});

	}
	else {
		$(".gallery1 a").click(function() {	
			var largePath = $(this).attr("href");
			location.href = "actualites.php?id="+largePath;
			return false;
	    });
	    $("#content nav li.navtit, #content nav li.navtit2").click(function() {	
			$(this).toggleClass('actif');
			$(this).nextAll().toggle();
			return false;
	    });
	}

	// Fonctions pour le calendrier dynamique

	var maDate = new Date();
	$('.month').hide();
	var currentYear = maDate.getFullYear();
	var activeYear = currentYear;
	var currentMonth = parseInt(maDate.getMonth(), 10) + 1;
	if(currentMonth < 7) {
		currentYear--;
	}
	
	$('#month'+currentMonth).show();
	$('.year a#linkYear'+activeYear).addClass('active');
	$('.months a#linkMonth'+currentMonth).addClass('active');
	
	$('.months a').click(function() {
		var month = $(this).attr('id').replace('linkMonth','');
		if(month != currentMonth) {
			if(month < 7) var year = parseInt(currentYear, 10) + 1; else var year = currentYear;
			$('#month'+currentMonth).slideUp();
			$('#month'+month).slideDown();
			$('.year a').removeClass('active');
			$('.year a#linkYear'+year).addClass('active');
			$('.months a').removeClass('active');
			$('.months a#linkMonth'+month).addClass('active');
			currentMonth = month;
		}
		return false;
	});
	
	$('.year a').click(function() {
		return false;
	});

	// Pour la popup de connexion

	$('#se_connecter').click(function() {
		$('#fond').show();
		$('#connexion').show();
		
		return false;
	});
	$('#fermer').click(function() {
		$('#fond').hide();
		$('#connexion').hide();
		return false;
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

function sliderAuto() {

	var idMiniImgActive = '#mini_image'+ id;

	var grdImgSource = $("#grandeImage .large_image").attr("src");
	var titreGrandeNews = $(".gallery1 dt .legende_actualite .titre_first").text();
	var sousTitreGrandeNews = $(".gallery1 dt .legende_actualite .sous_titre_first").text();
	var themeGrandeNews = $(".gallery1 dt .theme_actualite").text();	
	var idGrandeNews = $("#grandeImage").attr("href");

	var idPetiteNews = $(idMiniImgActive).attr("href");
	var imgPetiteNews = $(idMiniImgActive +' span span img').attr("src");
	var titrePetiteNews = $(idMiniImgActive +' span span .titre_mini').text();
	var sousTitrePetiteNews = $(idMiniImgActive +' span span .sous_titre_mini').text();
	var themePetiteNews = $(idMiniImgActive +' span span .theme_mini').text();
	
	$(".gallery1 dt").animate({ opacity: "0" }, "middle", function(){
		$("#grandeImage .large_image").attr({ src: imgPetiteNews});
		$("#grandeImage").attr("href", idPetiteNews);
		$(".gallery1 dt .legende_actualite .titre_first").text(titrePetiteNews);
		$(".gallery1 dt .legende_actualite .sous_titre_first").text(sousTitrePetiteNews);
		$(".gallery1 dt .theme_actualite").text(themePetiteNews);

		$(idMiniImgActive +' span span img').attr("src", grdImgSource);
		$(idMiniImgActive).attr("href", idGrandeNews);
		$(idMiniImgActive +' span span .titre_mini').text(titreGrandeNews);
		$(idMiniImgActive +' span span .sous_titre_mini').text(sousTitreGrandeNews);
		$(idMiniImgActive +' span span .theme_mini').text(themeGrandeNews);
	});
	$(".gallery1 dt").animate({ opacity: "1" }, "slow");

	id++;
	if(id == 4)
		id = 1;
}

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