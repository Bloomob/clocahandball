$(function(){

  /********************
	******* Menus *******
	********************/

	var admin_menu = $('.admin-panel .menu');

	if(admin_menu.length > 0) {

		/**** Sauvegarde menu ****/
		admin_menu.on('click', '.save-all', saveMenu(event));
		function saveMenu(e) {
			e.preventDefault();
			
			/* Variables */
			var MonMenu = new Array();
			var i = 1;


			tabs.find('.liste-tabs ul li').each(function (index) {
				var tab = $($(this).find('a').attr('href'));
				consol
				e.log(tab);

				if(tab.find('.btn-visiblity').hasClass('btn-invisible'))
					var actif = 1;
				else
					var actif = 0;
				// NOM - URL - PARENT - ORDRE - ACTIF
				MonMenu.push({'nom': tab.find('#menu-nom').val(), 'url': tab.find('#menu-url').val(), 'image': '', 'parent': 0, 'ordre': index*5, 'actif': actif});
				var id_parent = i;
				tab.find('.liste-menus > div').each(function (index_2) {
					MonMenu.push({'nom': $(this).find('.sous-menu-nom').val(), 'url': $(this).find('.sous-menu-url').val(), 'image': '', 'parent': id_parent, 'ordre': index_2*5, 'actif': 1});
					i++;
				});
				i++;
			});
			MonMenu.pop();
			// console.log(MonMenu);
			$('#main').append('<img src="/images/loading.gif" alt="chargement ..." class="ico_chargement" />');
			$.ajax({
				type: "POST",
				url: "inc/ajax/save_menu.php",
				data: { 
					menu: MonMenu
				},
				success: function(data) {
					// console.log(data);
					location.href = window.location.href;
				}
			});
		});
		}

    /*var tabs = $( "#onglets" ).tabs();
    tabs.find( ".ui-tabs-nav" ).sortable({
			axis: "x",
			items: '> li:not(.locked)',
			stop: function() {
				tabs.tabs( "refresh" );
			}
    });
		var count_tabs = tabs.find('.liste-tabs').length;*/
		
		// Lock last tab
		/*$('.liste-tabs ul > li:last').addClass('locked').mousedown(function(event){
			event.stopPropagation();
		});*/
		
		/*$( ".sortable" ).sortable({
			placeholder: "ui-state-highlight"
		});
		$( ".sortable" ).disableSelection();*/

		/* Ajout d'un menu */
		tabs.on('click', '.menu-action .btn-ajout', function(event) {
			event.preventDefault();
			if($('#nv_menu_nom').val() != '' && $('#nv_menu_url').val() != '') {
				var nv_nom = $('#nv_menu_nom').val();
				var nv_url = $('#nv_menu_url').val();
				var contenu = '<div class="paddingTB10 table"><div class="cell cell-1-2"><label for="menu-nom">Nom du menu</label><br/><input id="menu-nom" type="text" value="'+ nv_nom +'" /></div><div class="cell cell-1-2"><label for="menu-url">URL du menu</label><br/><input id="menu-url" type="text" value="'+ nv_url +'" /></div></div>';
				contenu += '<div class="boutons-actions menu-action"><div class="left"><a href="#" class="btn btn-suppr">Supprimer</a></div><div class="right"><a href="#" class="btn btn-visiblity btn-invisible">Masquer le menu</a></div><div class="clear_b"></div></div>';
				contenu += '<div class="liste-menus"><p>Pour cr&eacute;er un sous-menu, cliquer sur le bouton.</p></div><div class="boutons-actions sous-menus-action"><div class="right"><a href="#" class="btn btn-ajout">Ajouter un sous-menu</a></div><div class="clear_b"></div></div>';
				tabs.find(' ul li').eq( -1 ).before('<li><a href="#tabs-'+ count_tabs +'">'+ nv_nom +'</a></li>');
				tabs.find('.liste-tabs').eq( -1 ).before('<div id="tabs-'+ count_tabs +'" class="liste-tabs">'+ contenu +'</div>');
				$('#nv_menu_nom').val('');
				$('#nv_menu_url').val('');
				tabs.tabs("refresh");
				tabs.tabs("option", "active", tabs.find('.liste-tabs').length-2);
				count_tabs++;
			}
			return false;
		})
		/* Suppression d'un menu */
		.on('click', '.menu-action .btn-suppr', function(event) {
			event.preventDefault();
			var tab = tabs.tabs("option", "active");
			tabs.find('ul li').eq(tab).remove();
			tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls')-1).remove();
			tabs.tabs("refresh");
			tabs.tabs("option", "active", 0);
			return false;
		})
		/* MAsquer/Afficher un menu */
		.on('click', '.menu-action .btn-visiblity', function(event) {
			event.preventDefault();
			var tab = tabs.tabs("option", "active");
			var texte = $(this).text();
			$(this).toggleClass('btn-invisible btn-visible');
			tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').toggleClass('invisible');
			if(texte == 'Afficher le menu') {
				$(this).text('Masquer le menu');
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .sous-menus-action').show();
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus > .masque').remove();
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').sortable( { disabled: false } );
			}
			else {
				$(this).text('Afficher le menu');
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .sous-menus-action').hide();
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').append('<div class="masque"></div>');
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').sortable( { disabled: true } );
			}
			return false;
		})
		/* Ajout d'un sous menu */
		.on('click', '.sous-menus-action .btn-ajout', function(event) {
			event.preventDefault();
			closeAllSousMenus();
			var tab = tabs.tabs("option", "active");
			if(tabs.find('#tabs-'+ tab +' .liste-menus > p'))
				tabs.find('#tabs-'+ tab +' .liste-menus > p').remove();
			var count_div = tabs.find('#tabs-'+ tab +' .liste-menus > div').length;
			var contenu = '<div class="paddingTB10 table"><div class="cell cell-1-2"><label for="sous-menu-'+ count_div +'-nom">Nom du menu</label><br/><input type="text" id="sous-menu-'+ count_div +'-nom" class="sous-menu-nom" value=""/></div><div class="cell cell-1-2"><label for="sous-menu-'+ count_div +'-url">URL de la page</label><br/><input type="text" id="sous-menu-'+ count_div +'-url" class="sous-menu-url" value=""/></div></div>';
			var boutons = '<div class="boutons-actions sous-menus-action"><div class="left"><a href="#" class="btn btn-suppr">Supprimer</a></div><div class="clear_b"></div></div>';
			tabs.find('#tabs-'+ tab +' .liste-menus').append('<div class="sous-menu-'+ count_div +'"><h4>Nouveau menu<a href="'+ count_div +'" class="arrow-up right">D&eacute;tails</a></h4><div>'+ contenu + boutons +'</div></div>');
			return false;
		})
		/* Suppression d'un sous menu */
		.on('click', '.sous-menus-action .btn-suppr', function(event) {
			event.preventDefault();
			$(this).closest('.liste-menus > div').remove();
			return false;
		})
		/* Menu déroulant des sous menus */
		.on('click', '.liste-menus .arrow-up', function(event) {
			event.preventDefault();
			var id_menu = $(this).attr('href');
			$(this).toggleClass('arrow-up arrow-down');
			$('.sous-menu-'+id_menu).find('> div').hide();
			return false;
		})
		.on('click', '.liste-menus .arrow-down', function(event) {
			event.preventDefault();
			closeAllSousMenus();
			var id_menu = $(this).attr('href');
			$(this).toggleClass('arrow-down arrow-up');
			$('.sous-menu-'+id_menu).find('> div').show();
			return false;
		});

		function closeAllSousMenus() {
			$('.liste-menus > div > div').hide();
			$('.liste-menus > div > h4 > a').each(function() {
				if($(this).hasClass('arrow-up'))
					$(this).toggleClass('arrow-down arrow-up');
			});
		}
		/* Sauvegarde du menu */
		
	}
});