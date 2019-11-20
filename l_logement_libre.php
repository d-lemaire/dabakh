<!DOCTYPE html>
<html>
	<head>
		<title>Liste logements libres</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style=" background-image: url(<?=$image ?>l_logement_libre.jpg) ;">
		<?php
		include 'verification_menu_immo.php';
		?>
		<div class="row">
			<h3 class="center col s12 white-text" >Liste des logements libres</h3>
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
							<th data-field="">Bailleur</th>
							<th data-field="">Logement</th>
							<th data-field="">Type</th>
							<th data-field="">Nombre libre</th>
							<th data-field="">Adresse</th>
							<th data-field="">Prix location</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
			 $('.modal').modal();
			function l_logement_libre(search) {
				$.ajax({
					type:'POST',
					url:'l_logement_libre_ajax.php',
					data:'search='+search,
					success:function (html) {
						$('tbody').html(html);
					}
				});
			}

			var search ="";
			l_logement_libre(search);
			$('input:first').keyup(function(){
			var search = $('input:first').val();
			l_logement_libre(search)
				});
			$('.tooltipped').tooltip();
	});
	</script>
	<style type="text/css">
		
		table
		{
			background: white;
			font: 12pt "times new roman";
		}
	</style>
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
			a, .btn{
				display: none;
			}
		}
	</style>
</html>