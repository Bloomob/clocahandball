$(function() {
	// there's the gallery and the trash
	var $gallery = $( "#gallery" ),
		$trash = $( "#trash" );

	// let the gallery items be draggable
		$( "li", $gallery ).draggable({
			cancel: "a.ui-icon", // clicking an icon won't initiate dragging
			revert: "invalid", // when not dropped, the item will revert back to its initial position
			containment: $( "#demo-frame" ).length ? "#demo-frame" : "document", // stick to demo-frame if present
			helper: "clone",
			cursor: "move"
		});

	// let the trash be droppable, accepting the gallery items
	$trash.droppable({
		accept: "#gallery > li",
		activeClass: "ui-state-highlight",
		drop: function( event, ui ) {
			deleteImage( ui.draggable );
		}
	});

	// let the gallery be droppable as well, accepting items from the trash
	$gallery.droppable({
		accept: "#trash li",
		activeClass: "custom-state-active",
		drop: function( event, ui ) {
			recycleImage( ui.draggable );
		}
	});

	// image deletion function
	var recycle_icon = "<a href='#' title='Supprimer de la liste' class='ui-icon ui-icon-refresh'>Supprimer de la liste</a>";
	function deleteImage( $item ) {
		var $compteur = $( "li", $trash ).length;
		var $cpt = parseInt($compteur) + parseInt(1);
		if($compteur < $( "h4 span.num_max", $trash ).text()) {
			$item.fadeOut(function() {
				var $list = $( "ul", $trash ).length ?
					$( "ul", $trash ) :
					$( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $trash );
				
				$item.find( "a.ui-icon-plus" ).remove();
				$item.prepend( recycle_icon ).appendTo( $list ).fadeIn(function() {
					$item
						.animate({ width: "192px" })
						.find( "img" )
							.animate({ height: "36px" });
					$( "h4 span.num_actif", $trash ).text($cpt);
					$( "#recupDerMatch" ).disabled = true;
				});
			});
		}
	}

	// image recycle function
	var trash_icon = "<a href='#' title='Ajouter ce joueur' class='ui-icon ui-icon-plus'>Ajouter ce joueur</a>";
	function recycleImage( $item ) {
		$item.fadeOut(function() {
			$item
				.find( "a.ui-icon-refresh" )
					.remove()
				.end()
				.css( "width", "170px")
				.find( "div" )
					.append( trash_icon )
				.end()
				.find( "img" )
					.css( "height", "72px" )
				.end()
				.appendTo( $gallery )
				.fadeIn(function() {
					var $compteur = $( "li", $trash ).length;
					var $cpt = $compteur--;
					$( "h4 span.num_actif", $trash ).text($cpt);
					if($cpt==0)
						$( "#recupDerMatch" ).disabled = true;
				});
		});
	}

	// image preview function, demonstrating the ui.dialog used as a modal window
	function viewLargerImage( $link ) {
		var src = $link.attr( "href" ),
			title = $link.siblings( "img" ).attr( "alt" ),
			$modal = $( "img[src$='" + src + "']" );
		if ( $modal.length ) {
			$modal.dialog( "open" );
		} else {
			var img = $( "<img alt='" + title + "' width='125' height='125' style='display: none; padding: 8px;' />" )
				.attr( "src", src ).appendTo( "body" );
			setTimeout(function() {
				img.dialog({
					title: title,
					draggable: false,
					resizable: false,
					width: 150,
					height: 150,
					modal: true
				});
			}, 1 );
		}
	}

	// resolve the icons behavior with event delegation
	$( "ul.gallery > li" ).click(function( event ) {
	var $item = $( this ),
		$target = $( event.target );
	if ( $target.is( "div a.ui-icon-plus" ) ) {
		deleteImage( $item );
	} else if ( $target.is( "div a.ui-icon-zoomin" ) ) {
		viewLargerImage( $target );
	} else if ( $target.is( "div a.ui-icon-refresh" ) ) {
		recycleImage( $item );
	}

	return false;
});
	
	// $( "#toutSelect" ).click(function() {
		// deleteImage( $( "#gallery > li" ) );
	// });
	
	
});

