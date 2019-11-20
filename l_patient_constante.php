<?php
session_start();
include 'connexion.php';
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Choix du patient</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_patient_soins.png);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<h4 class="center col s12 white-text" >Choix du patient pour enregistrer une constante</h4>
		<div class="row ">
			<div class="input-field col s4 white" style="border-radius: 20px;">
				<i class="material-icons prefix">search</i>
				<input id="search" type="text" class="validate" placeholder="Recherche par nom et/ou prénom" name="search">
			</div>
		<div class="row">
			<div class="col s10 offset-s1 ">
				<table class="bordered highlight centered striped">
					<thead>
						<tr style="color: #0d47a1">
							<th  data-field=""></th>
							<th  data-field="">N° Dossier</th>
							<th data-field="">Prénom et Nom</th>
							<th data-field="">Date et lieu de naissance</th>
							<th data-field="">Profession</th>
							<th data-field="">Domicile</th>
							<th data-field="">Telephone</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		
	</body>
	<style type="text/css">
		body
		{
			background-position: center center;
			background-repeat:  no-repeat;
			background-attachment: fixed;
			background-size:  cover;
			background-color: #999;
		}
		table
		{
			background: white;
		}
	</style>
	<script type="text/javascript">
			$(document).ready(function(){
			function l_patient_constante(s) 
			{
				$.ajax({
					type:'POST',
					url:'l_patient_constante_ajax.php',
					data:'search='+s,
					success:function (html) {
						$('tbody').html(html);
					}
				});
			}
			var search ="";
			l_patient_constante(search);
			$('input:first').keyup(function(){
			var search = $('input:first').val();
			l_patient_constante(search);
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