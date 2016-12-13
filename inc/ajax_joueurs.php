<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	
	if(isset($_POST['raccourci']))
		$cat = $_POST['raccourci'];
	if(isset($_POST['j']))
		$j = $_POST['j'];
?>
<script>
	$(function() {
		$( "#tab_joueurs_<?=$j?> div" ).click(function( event ) {
			if($( event.target ).is( 'a.add_player' )) {
				var new_form = "";
				new_form += "<tr class='nouveau_joueur'>";
				new_form += 	"<td><select id='numero' name='numero'>";
								for(var i = 1; i<100; i++){
				new_form += 		"<option value='"+ i +"'>"+ i +"</option>";
								}
				new_form += 	"</select></td>";
				new_form += 	"<td><input id='nom' name='nom' size='8'/></td>";
				new_form += 	"<td><input id='prenom' name='prenom' size='8'/></td>";
				new_form += 	"<td><select id='poste' name='poste'>";
				new_form += 		"<option value='0'>-</option>";
				new_form += 		"<option value='1'>Gardien</option>";
				new_form += 		"<option value='2'>Demi-centre</option>";
				new_form += 		"<option value='3'>Arri&egrave;re Gauche</option>";
				new_form += 		"<option value='4'>Arri&egrave;re Droit</option>";
				new_form += 		"<option value='5'>Ailier Gauche</option>";
				new_form += 		"<option value='6'>Ailier Droit</option>";
				new_form += 		"<option value='7'>Pivot</option>";
				new_form += 	"</select></td>";
				new_form += 	"<td colspan='3'><input type='button' id='ajout_joueur_<?=$j?>' value='Ajouter'/></td>";
				new_form += "</tr>";
				$( new_form ).appendTo( "#tab_joueurs_<?=$j?>" );
			}
			return false;
		});
		
		$( "#ajout_joueur_<?=$j?>" ).live( "click", function() {
			var cat = $("#tab_joueurs_<?=$j?> a.add_player").attr("href").split('_');
			// alert("raccourci: "+cat+", numero: "+$('#numero').val()+", nom: "+$('#nom').val()+", prenom: "+$('#prenom').val()+", poste: "+$('#poste').val());
			$.ajax({
				type: "POST",
				url: "inc/ajax_ajout_joueur.php",
				data: {
					raccourci: cat[0],
					numero: $('#numero').val(),
					nom: $('#nom').val(),
					prenom: $('#prenom').val(),
					poste: $('#poste').val()
				},
				success: function(data) {
					// alert(data);
					$('#tab_joueurs_<?=$j?> tr:gt(0)').remove();
					$('#tab_joueurs_<?=$j?> tbody').append( data );
				}
			});
		});
	});
</script>
<div class="add_joueur"><?php
	$listeJoueurs = liste_joueurs($cat);?>
	<table id="tab_joueurs_<?=$j?>">
		<tr>
			<th colspan="7">Liste des joueurs<div class="right"><a href="<?=$cat;?>_<?=$j;?>" class="add_player">Ajouter un joueur</a></div></th>
		</tr>
		<tr class="cell1">
			<td>N&deg;</td>
			<td>Nom</td>
			<td>Pr&eacute;nom</td>
			<td>Poste</td>
			<td>Age</td>
			<td>Au club</td>
			<td>Photo</td>
		</tr>
		<?
		if(is_array($listeJoueurs)) {
			$i=2;
			$poste = '';
			foreach($listeJoueurs as $unJoueur) {?>
				<tr class="cell<?=$i;?>">
					<td><?=$unJoueur['num'];?></td>
					<td><?=$unJoueur['nom'];?></td>
					<td><?=$unJoueur['prenom'];?></td>
					<td><?=$unJoueur['poste'];?></td>
					<td><?=$unJoueur['age'];?></td>
					<td><?=$unJoueur['annee_arrivee'];?></td>
					<td><?=$unJoueur['affiche_photo'];?></td>
				</tr><?php
				$i++;
				if($i==3) $i=1;
			}
		}
		else {?>
			<tr><td colspan="7">Pas de joueur enregistr&eacute; pour cet &eacute;quipe.</td></tr><?php
		}?>
	</table>
</div>