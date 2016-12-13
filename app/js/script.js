$(function(){
	/* PAGE NON CONNECTE */
	if($('.not-connected').length > 0) {
		$.getJSON('json/actualite.json')
			.done(function(data){
				var maDate = new Date(data.date);
				var moisFR = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

				$('.bloc-header .date .jour').text(maDate.getDate());
				$('.bloc-header .date .mois-annee').html(moisFR[maDate.getMonth()] + '<br/>' + maDate.getFullYear());
				$('.bloc-header .titre h3').text(data.titre);
				$('.article-content').html(data.texte);
			})
			.fail(function(error) {
			    console.log( error );
			});
	}

	/* MENU */
	var affichageMenu = function() {
		$nav = $('nav.menu');
		$nav.find('.cat-menu a').removeClass('active');
		$nav.find('.sous-menu').removeClass('active');
		$nav.mouseover(function(e){
			$target = $(e.target);
			if($target.parent().hasClass('cat-menu')){
				var isActive = false;
				var cat_nom = $target.data('nom');

				if(!$nav.find('[data-parent="'+cat_nom+'"]').hasClass('active'))
					isActive = true;

				$nav.find('.cat-menu a').removeClass('active');
				$nav.find('.sous-menu').removeClass('active');

				if(isActive) {
					$target.addClass('active');
					$nav.find('[data-parent="'+cat_nom+'"]').addClass('active').find('.categorie').html('<h3>' + $target.text() + '</h3>');
				}
			}
			return false;
		}).mouseleave(function(e){
			$nav.find('.cat-menu a').removeClass('active');
			$nav.find('.sous-menu').removeClass('active');
		});
	};


	var gestionMenuMobile = function() {
		$body = $('body');
		$btnMenu = $('.btnMenu');
		$menuMobile = $('.menu-mobile');

		$btnMenu.on('touchstart click',function(e){
			e.preventDefault();

			/* Cross browser support for CSS "transition end" event */
      		transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

			$body.addClass('animating left');

			/***
			* When the animation (technically a CSS transition)
			* has finished, remove all animating classes and
			* either add or remove the "menu-visible" class 
			* depending whether it was visible or not previously.
			*/
			$menuMobile.on( transitionEnd, function() {
				$body
				.removeClass( 'animating left' )
				.addClass( 'menu-visible' );

				$menuMobile.off( transitionEnd );
			});
		});
		
		$menuMobile.on('touchstart click', function(e){
			e.preventDefault();
			$target = $(e.target);
			var isActive = false;
			if($target.hasClass('menu-mobile')) {
				/* Cross browser support for CSS "transition end" event */
	      		transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

				$body.addClass('animating right');
				
				$menuMobile.on( transitionEnd, function() {
					$body
					.removeClass( 'animating right menu-visible' );

					$menuMobile.off( transitionEnd );
				});
			} else if($target.parents('.menu-content').length) {
				isParent = $target.closest('li').find('> ul').length;
				
				if(isParent) {
					$target.parents('.menu-content').find('> ul > li > a').removeClass('active');

					if(!$target.closest('li').find('> a').hasClass('active'))
						$target.closest('li').find('> a').addClass('active');
				}
			}
		});
	};

	/* Affichage du Mini Header au scroll */
	var scrollMiniHeader = function() {
		$('header').removeClass('scroll');
		$(window).scroll(function(){
			if($(window).width() > 991) {
				if($(window).scrollTop() > 115) {
					$('header').addClass('scroll');
				} else {
					$('header').removeClass('scroll');
				}
			}
			else {
				if($(window).scrollTop() > $('.header-top').height()) {
					$('header').addClass('scroll');
				} else {
					$('header').removeClass('scroll');
				}
			}
		});
	};

	/* Affichage de la recherche latérale */
	var rechercheLaterale = function() {
		$search = $('.recherche-lateral');
		$search.find('input').hide();
		$search.find('a').click(function(){
			$search.find('input').toggle();
			return false;
		})
	};

	/* Carousel des brèves */
	var carouselBreves = function() {
		$carousel = $('#carousel-breves');
		$carousel.find('.item').each(function(){
			var itemToClone = $(this);

			for(var i=0; i < $carousel.find('.item').length-1; i++) {
				itemToClone = itemToClone.next();

				if (!itemToClone.length) {
			        itemToClone = $(this).siblings(':first');
			    }
			    itemToClone.find('.slider:first').clone()
		        		   .addClass("cloneditem-"+i)
		        		   .appendTo($(this).find('.row'));
		    }
		});
	};

	/* Carousel de la home */
	var carouselHome = function() {
		$carouselHome = $('#carousel-home');
		$carouselHome.find('.item').each(function(){
			var itemToClone = $(this);

			itemToClone = itemToClone.next();

			if (!itemToClone.length) {
		        itemToClone = $(this).siblings(':first');
		    }
		    var contenuClone = $(this).find('.contenu-une-actualite:first').clone().addClass("contenuCloned");
		    itemToClone.find('.doubleSlide:first').clone()
	        		   .addClass("cloneditem")
	        		   .appendTo($(this).children().first())
	        		   .append(contenuClone);
		});
		
		// Duplication des images pour les grands écrans
		var image1Active = $carouselHome.find('.item.active .doubleSlide:first img');
		var image2Active = $carouselHome.find('.item.active .doubleSlide:last img');
		var image1Clone = image1Active.clone();
		var image2Clone = image2Active.clone();
		$carouselHome.find('.background-left').css('left', '-'+image1Active.width()+'px').html(image1Clone);
		$carouselHome.find('.background-right').css('right', '-'+image2Active.width()+'px').html(image2Clone);
		
		$carouselHome.on('slid.bs.carousel', function () {
			var image1Active = $carouselHome.find('.item.active .doubleSlide:first img');
			var image2Active = $carouselHome.find('.item.active .doubleSlide:last img');
			var image1Clone = image1Active.clone();
			var image2Clone = image2Active.clone();
			$carouselHome.find('.background-left').css('left', '-'+image1Active.width()+'px').html(image1Clone);
			$carouselHome.find('.background-right').css('right', '-'+image2Active.width()+'px').html(image2Clone);
		});
	};

	/* Carousel de la boutique détails */
	var carouselBoutiqueDetails = function() {
		$carousel = $('#carousel-autres-produits');
		$carousel.find('.item').each(function(){
			var itemToClone = $(this);

			for(var i=0; i < $carousel.find('.item').length-1; i++) {
				itemToClone = itemToClone.next();

				if (!itemToClone.length) {
			        itemToClone = $(this).siblings(':first');
			    }
			    itemToClone.find('.slider:first').clone()
		        		   .addClass("cloneditem-"+i)
		        		   .appendTo($(this).find('.row'));
		    }
		});
	};

	/* Dropdown Toggle perso */
	var myDropdownToggle = function() {
		$('.myDropdown-toggle').on('touchstart click', function(){
			var name = $(this).data('toggle');
			if(!$('#'+ name).hasClass('open')) {
				$('.myDropdown, .myDropdown-menu').removeClass('open');
				$('body').removeClass('mask').find('.fond').remove();
				$('#'+ name).addClass('open');
				// Affichage d'un masque de fond
				if($(this).data('popin')) {
					$('body').addClass('mask').append($('<div/>').addClass('fond'));

					$('body.mask .fond').on('touchstart click', function(e){
						e.preventDefault();
						$('.myDropdown, .myDropdown-menu').removeClass('open');
						$('body').removeClass('mask').find('.fond').remove();
					});
				}
				// Affichage du dropdown jusqu'en bas de page
				if($(this).data('window')) {
					if($('header').hasClass('scroll'))
						var h = 39;
					else 
						var h = $('header').height();

					if($('#'+ name +' .myDropdown-menu').height() > $(window).height() - h)
						$('#'+ name +' .myDropdown-menu').height($(window).height() - h);
				}
				// Patch uniquement pour Mes Applis dans le header
				if($(this).hasClass('applis-head')) {
					$('nav.menu').addClass('applis-open');
					$('.rechercheEtApplis').addClass('applis-open');
				}
				if($(this).hasClass('applis-bandeau')) {
					$('nav.menu').addClass('applis-open');
					$('.rechercheEtApplis').addClass('applis-open');
				}
				$('#'+ name).find('.fermer').on('touchstart click', function(e){
					e.preventDefault();
					$('.myDropdown, .myDropdown-menu').removeClass('open');
					$('body').removeClass('mask').find('.fond').remove();
					$('.rechercheEtApplis, nav.menu').removeClass('applis-open');
				});
			} else {
				$('.myDropdown, .myDropdown-menu').removeClass('open');
				$('body').removeClass('mask').find('.fond').remove();
				$('.rechercheEtApplis, nav.menu').removeClass('applis-open');
			}

			return false;
		});
	}

	/* Back to top */
	var backTop = function() {
		$(window).scroll(function(){
			$footer = $('footer');
			if($(window).scrollTop() > 0) {
				$('.back-top').show();

				if($(window).scrollTop() > $('body').height() - $(window).height() - $footer.height()) {
					$('.back-top').addClass('bottom');
				} else {
					$('.back-top').removeClass('bottom');
				}

				$('.back-top').click(function() {
					$(window).scrollTop(0);
					return false;
				});
			} else {
				$('.back-top').hide();
			}
			
		});
	};

	/* Personnalisation de la home */
	var persoDraggable = function() {

		function backToDragList(){
			$target = $(this).closest('.draggable').not('.disable');
			$target.find('.titre-widget').toggleClass('col-sm-8 col-sm-7');
			$target.find('>div').last().remove();
			$('.listeDraggable').append($target);
			return false;
		}

		$('.listeDroppable .suppr').click(backToDragList);

		Sortable.create(listePull, {
			group: {
				name: 'sortable',
				pull: true,
				put: false
			},
			handle: '.draggable',
			animation: 150,
			sort: false
		});

		Sortable.create(listePut, {
			group: {
				name: 'sortable',
				pull: false,
				put: true
			},
			handle: '.draggable',
			animation: 150,
			onAdd: function (evt) {
		        var itemEl = evt.item;
		        if($(itemEl).find('>div').length < 5) {
					$(itemEl).find('.titre-widget').toggleClass('col-sm-8 col-sm-7');
					$(itemEl).append($('<div/>').addClass('col-sm-1').html('<a href="#" class="suppr"><i class="fa fa-trash" aria-hidden="true"></i></a>'));
				}
				$(itemEl).find('.suppr').click(backToDragList);
			}
		});

		$('.draggable .voir').click(function(){
			var id = $(this).data('id');
			console.log(id);
			$.getJSON('json/personnaliser-home.json')
				.done(function(data){
					$.each( data.items, function( i, item ) {
						if(item.id == id) {
							$('.description-widget').show();
							$('.description-widget h3').text(item.titre);
							$('.description-widget .contenu').html(item.texte);
							$('.description-widget .affichage .colonne').html(item.colonne);
							$('.description-widget .affichage .ligne').html(item.ligne);
						}
					});
				})
				.fail(function(error) {
				    console.log( error );
				});
			return false;
		});
	};

	/* Home documents */
	var homeDocuments = function() {
		var actualise = function () {
			$.getJSON('json/documents.json')
				.done(function(data){
					var k = '';
					$('.documents .wrapper .row').html('');
					$.each( data.items, function( i, item ) {
						if(i < 4) {
							if(i>1) k = 'hidden-xs hidden-sm';
							$('.documents .wrapper .row').append(
								$('<div/>').addClass(k + ' col-md-6 box').append(
									$('<div/>').addClass('doc ' + item.type).append(
										$('<a/>').attr('href', item.url).append(
											$('<i/>').addClass('fa ' + item.icone).attr('aria-hidden', true),
											$('<p/>').addClass('contenu').text(item.titre),
											$('<p/>').addClass('infos-complementaires').text('.' + item.format + ' - ' + item.taille + ' - ' + item.date)
										)
									)
								)
							);
						} else {
							return false;
						}
					});
				})
				.fail(function(error) {
				    console.log( error );
				});
		}
		// Au refresh on relance l'appel à la fonction d'actualisation du contenu
		$('.documents .actualise > a').click(function(e) {
			e.preventDefault();
			actualise();
		});
		actualise();
	};

	/* Home évènements réseaux */
	var homeEvents = function() {
		var actualise = function () {
			$.getJSON('json/evenements-reseaux.json')
				.done(function(data){
					var k = '';
					$('.detail-event').hide();
					$('.evenements-reseaux .liste-events').html('');
					$.each( data.items, function( i, item ) {
						if(i < 4) {
							var maDate = new Date(item.date);
							var moisFR = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
							
							if(i>1) k = 'hidden-xs hidden-sm ';
							$('.evenements-reseaux .liste-events').append(
								$('<div/>').addClass(k + 'event').append(
									$('<p/>').addClass('titre-event')
										.text(item.titre),
									$('<p/>').addClass('date-event')
										.data('jour', maDate.getDate())
										.data('mois', moisFR[maDate.getMonth()])
										.data('annee', maDate.getFullYear())
										.text(maDate.getDate() + ' ' + moisFR[maDate.getMonth()] + ' ' + maDate.getFullYear())
										.prepend(
											$('<i/>').addClass('fa fa-calendar').attr('aria-hidden', true)
										),
									$('<a/>').addClass('plus').attr('href', '#')
								).mouseover(function() {
									if($(window).width() > 991) {
										$('.detail-event .jour').text($(this).find('.date-event').data('jour'));
										$('.detail-event .mois').text($(this).find('.date-event').data('mois'));
										$('.detail-event .annee').text($(this).find('.date-event').data('annee'));
										$('.detail-event').css('top', $(this).position().top+'px');
										$('.detail-event').show();
									}
								}).mouseleave(function() {
									$('.detail-event').hide();
								})
							);
						} else {
							return false;
						}
					});
				})
				.fail(function(error) {
				    console.log( error );
				});
		}
		// Au refresh on relance l'appel à la fonction d'actualisation du contenu
		$('.evenements-reseaux .actualise > a').click(function(e) {
			e.preventDefault();
			actualise();
		});
		actualise();
	};
	
	/* Home agences */
	var homeAgences = function() {
		var actualise = function () {
			$.getJSON('json/agences.json')
				.done(function(data){
					$('.agences .wrapper').html('');
					$.each( data.items, function( i, item ) {
						if(i < 2) {
							var photo = $('<div/>').addClass('col-xs-6 box').append(
								$('<div/>').addClass('photo').append(
									$('<img/>').attr('src', 'images/' + item.image_agence).attr('alt', 'Image agence ' + item.ville)
								)
							);
							var infos = $('<div/>').addClass('col-xs-6 box').append(
								$('<div/>').addClass('description').append(
									(item.photo != '')?$('<img/>').addClass('photo-chef-agence hidden-xs hidden-sm').attr('src', 'images/' + item.photo).attr('alt', 'Photo de ' + item.nom):$('<p/>').addClass('departement hidden-xs hidden-sm').text(item.departement),
									$('<p/>').addClass('chef-agence').text(item.nom),
									(item.role != '')?$('<p/>').addClass('fonction').text(item.role):'',
									$('<div/>').addClass('ville').append(
										$('<p/>').addClass('map').append(
											$('<i/>').addClass('fa fa-map-marker hidden-xs hidden-sm').attr('aria-hidden', true),
											$('<span/>').text((item.photo!='')?item.ville+' ('+item.departement+')':item.ville)
										),
										$('<a/>').addClass('plus').attr('href', '#')
									)
								)
							);
							if(i == 0)
								var template = $('<div/>').addClass('row agence template1').append(photo, infos);
							else
								var template = $('<div/>').addClass('row agence template2').append(infos, photo);
							
							$('.agences .wrapper').append(template);
						} else {
							return false;
						}
					});
				})
				.fail(function(error) {
				    console.log( error );
				});
		}
		// Au refresh on relance l'appel à la fonction d'actualisation du contenu
		$('.agences .actualise > a').click(function(e) {
			e.preventDefault();
			actualise();
		});
		actualise();
	};

	/* Home challenges */
	var homeChallenges = function() {
		var actualise = function () {
			$.getJSON('json/challenges.json')
				.done(function(data){
					var k = '',	
							l = '';
					$('.challenges .wrapper .challenge').html('');
					$.each( data.items, function( i, item ) {
						if(i < 4) {
							if(i>1) k = 'hidden-xs hidden-sm ';
							if(i==1) l = ' fond1'; else if(i==2) l = ' fond2'; else l = '';
							$('.challenges .wrapper .challenge').append(
								$('<div/>').addClass(k + 'col-md-6 box').append(
									$('<a/>').addClass('statistique' + l).attr('href', item.url).append(
										$('<i/>').addClass('fa ' + item.picto).attr('aria-hidden', true),
										$('<div/>').addClass('chiffre').html('<p>'+ item.chiffre +'</p>'),
										$('<p/>').addClass('titre2').text(item.titre),
										$('<p/>').addClass('description').text(item.sous_titre)
									)
								)
							);
						} else {
							return false;
						}
					});
				})
				.fail(function(error) {
				    console.log( error );
				});
		}
		// Au refresh on relance l'appel à la fonction d'actualisation du contenu
		$('.challenges .actualise > a').click(function(e) {
			e.preventDefault();
			actualise();
		});
		actualise();
	};

	/* Home carrieres */
	var homeCarrieres = function() {
		var actualise = function (titre = '') {
			$.getJSON('json/carrieres.json', {titre: titre})
				.done(function(data){
					var k = '',
						j = 0;
					$('.carrieres .wrapper .row div.box:gt(0)').remove();
					$.each( data.items, function( i, item ) {
						if(titre == item.titre || titre == '' || titre == 'Tout') {
							if(j < 5) {
								if(j>1) k = 'hidden-xs hidden-sm ';
								$('.carrieres .wrapper .row').append(
									$('<div/>').addClass(k + 'col-xs-12 col-sm-6 col-lg-4 box').append(
										$('<div/>').addClass('carriere').append(
											$('<div/>').addClass('departement').append(
												$('<i/>').addClass('fa fa-map-marker').attr('aria-hidden', true),
												$('<p/>').addClass('numero').text(item.departement)
											),
											$('<div/>').addClass('emploi').append(
												$('<p/>').addClass('role').text(item.titre),
												$('<p/>').addClass('lieu').append(
													$('<span/>').text(item.role +' | '+ item.ville),
													$('<a/>').addClass('plus').attr('href', item.url)
												)
											)
										)
									)
								);
								j++;
							}
						}
					});
					$('.carrieres select').on('changed.bs.select', function(e, clickedIndex, newValue, oldValue) {
						var selected = $(e.currentTarget).val();
						actualise(selected);
					});
				})
				.fail(function(error) {
				    console.log( error );
				});
		}
		// Au refresh on relance l'appel à la fonction d'actualisation du contenu
		$('.carrieres .actualise > a').click(function(e) {
			e.preventDefault();
			actualise($('.carrieres select option:selected').val());
		});
		actualise();
	};

	// Menu latéral de la page article détail
	var menulateral = function () {
		$('.menu-lateral > ul > li > a').click(function(){
			if($(this).parent().hasClass('active')) {
				$('.menu-lateral > ul > li').removeClass('active');
				$('.menu-lateral > ul > li > a').find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
			} else {
				$('.menu-lateral > ul > li').removeClass('active');
				$('.menu-lateral > ul > li > a').find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
				$(this).parent().addClass('active');
				$(this).find('.fa').addClass('fa-chevron-up').removeClass('fa-chevron-down');
			}
			return false;
		});
	};

	// Select custom
	var dropdownSelect = function () {
		$('.dropdown.select').each(function(){
			$(this).find('ul li a').click(function(){
				$(this).closest('.dropdown.select').find('.valeur').text($(this).text());
			});
		});
	};

	// Notifications
	var checkNotifications = function () {
		var notif1 = function () {
			$.notify({
				message: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
			},{
				type: 'blanc',
				animate: {
					enter: 'animated fadeInRight',
					exit: 'animated fadeOutRight'
				},
				placement: {
					from: 'bottom',
					align: 'left'
				}
			});
			setTimeout(notif1, 12000);
		}
		var notif2 = function () {
			$.notify({
				message: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
			},{
				type: 'marron',
				animate: {
					enter: 'animated fadeInRight',
					exit: 'animated fadeOutRight'
				},
				placement: {
					from: 'bottom',
					align: 'left'
				}
			});
			setTimeout(notif2, 20000);
		}
		if($(window).width() > 991) {
			setTimeout(notif1, 12000);
			setTimeout(notif2, 20000);
		}
	};

	/* Carousel de la sous home */
	var carouselSousHome = function() {
		$carousel = $('#carousel-documents');
		$carousel.find('.item').each(function(){
			var itemToClone = $(this);

			for(var i=0; i < $carousel.find('.item').length-1; i++) {
				itemToClone = itemToClone.next();

				if (!itemToClone.length) {
			        itemToClone = $(this).siblings(':first');
			    }
			    itemToClone.find(':first').clone()
		        		   .addClass("cloneditem-"+i)
		        		   .appendTo($(this));
		    }
		});
	};

	// Tab de la sous-home
	var tabSousHome = function () {
		$('.tab a').click(function(){
			if(!$(this).hasClass('active')) {
				$('.tab a').removeClass('active');
				$(this).addClass('active');
				$('.documents, .articles').toggle();
			}
			return false;
		});
	};

	// Tab de la sous-home
	var calendar = function () {
		if($('#calendrier').length > 0) {
			$('#calendrier').fullCalendar({
		        lang: 'fr',
		        header: {
				    left:   'month,agendaWeek,agendaDay',
				    center: 'title',
				    right:  'today prev,next'
				},
				selectable: true,
				selectHelper: true,
				select: function(start, end) {
					var title = prompt('Event Title:');
					var eventData;
					if (title) {
						eventData = {
							title: title,
							start: start,
							end: end
						};
						$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
					}
					$('#calendar').fullCalendar('unselect');
				},
				editable: true,
				events: [
			        {
			            title: 'My Event',
			            start: '2016-05-25',
			            description: 'This is a cool event'
			        }
			        // more events here
			    ],
			    eventColor: '#e3d487'
		    });
		}
	};

	// Choix vue page boutique
	var choixVue = function () {
		$('.choix-vue button').click(function(){
			if(!$(this).hasClass('disabled')) {
				$('.choix-vue button').removeClass('disabled');
				if($(this).hasClass('fournisseurs')) {
					$('.liste-produits, .liste-fournisseurs').toggleClass('hidden');
					$(this).addClass('disabled');
				}
				if($(this).hasClass('produits')) {
					$('.liste-produits, .liste-fournisseurs').toggleClass('hidden');
					$(this).addClass('disabled');
				}
			}
			return false;
		});
	};

	// On applique un slider sur la liste des applis du header
	var bxSliderApplis = function () {
		if($('.bxslider').length > 0){
			$('.bxslider').bxSlider({
				pager: false,
				adaptiveHeight: true
			});
		}
	};

	
	// Globals events
	if($('.connected').length > 0) {
		affichageMenu();
		gestionMenuMobile();
		scrollMiniHeader();
		rechercheLaterale();
		myDropdownToggle();
		backTop();
		dropdownSelect();
		checkNotifications();
		bxSliderApplis();
	}
	// Home events
	if($('.connected.home').length > 0) {
		carouselBreves();
		carouselHome();
		persoDraggable();
		homeDocuments();
		homeEvents();
		homeAgences();
		homeChallenges();
		homeCarrieres();
	}
	// Sous home events
	if($('.connected.sous-home').length > 0) {
		carouselBreves();
		carouselSousHome();
		tabSousHome();
	}

	// Articles detail events
	if($('.connected.article-detail').length > 0) {
		menulateral();
	}
	// Page Boutique
	if($('.boutique').length > 0) {
		choixVue();
	}
	// Page Boutique détails
	if($('.boutique-details').length > 0) {
		carouselBoutiqueDetails();
	}
	// Page CMS
	if($('.page-cms').length > 0) {
		calendar();
	}

	/*$( window ).resize(function() {
		scrollMiniHeader();
		detailEvent();
	});*/
});