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
				console.log(tab);

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
		}
	}
});