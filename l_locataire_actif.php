<!DOCTYPE html>
<html>
	<head>
		<title>Liste des locataires</title>
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url(<?=$image ?>l_locataires.jpg) ;">
		<?php
		include 'verification_menu_immo.php';
		?>
		<div class="row">
			<h4 class="center col s12 white-text" >Liste des locataires actif</h4>
			<div class="col s4 input-field white" style="border-radius: 45px">
				<i class="material-icons prefix">search</i>
				<input type="text" name="search" id="search">
				<label for="search">Prénom / Nom</label>
			</div>
			<div class="col s12   ">
				<table class="bordered highlight centered striped">
					<thead>
						<tr style="color: #0d47a1">
							<th  data-field=""></th>
							<th  data-field="">N° dossier</th>
							<th data-field="prenom">Prénom et nom</th>
							<th data-field="nom">cni</th>
							<th data-field="tel">N° Téléphone</th>
							<th ></th>
						</tr>
					</thead>
					<tbody>
						
						
					</tbody>
				</table>
			</div>
		</div>
		
	</body>
	<style type="text/css">
		
		table
		{
			background: white;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.tooltipped').tooltip();
			function l_locataires(search) {
				$.ajax({
					type:'POST',
					url:'l_locataire_actif_ajax.php',
					data:'search='+search,
					success:function (html) {
						$('tbody').html(html);
					}
				});
			}

			var search ="";
			l_locataires(search);
			$('input:first').keyup(function(){
			var search = $('input:first').val();
			l_locataires(search)
				});
		});
	</script>
	<style type="text/css">

		/*import du css de materialize*/
		@import "../css/materialize.min.css" print;
		/*CSS pour la page à imprimer */
		/*Dimension de la page*/
		@page
		{
			size: portrait;
			margin: 0;
			margin-top: 25px;
		}
		@media print
		{
			button{
				display: none;
			}
			nav{
				display: none;
			}
			div
			{
			font: 12pt "times new roman";
			}
			select{
				border-color: transparent
			}
		}
	</style>
</html>