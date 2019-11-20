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
		<title>Choisir du patient</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_cons_d.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
			<h4 class="center col s12 black-text" >Choix du patient pour le soins à domicile</h4>
			  

		<div class="row ">
			<div class="row">
				<div class="col s4 offset-s10">
					<a class="btn waves-effect waves-light" href="e_patient.php">Nouveau patient+</a>
				</div>
			</div>
			<div class="row grey">
				<div class="col s4 input-field ">
					<i class="material-icons prefix white-text">search</i>
					<input type="text" class="white-text" placeholder="Recherche un patient" name="search" id="search">
				</div>
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
		 $(document).ready(function(){
    $('.fixed-action-btn').floatingActionButton();
  });	
			var search ="";
			$.ajax({
				type:'POST',
				url:'l_patient_cons_ajax_d.php',
				data:'search='+search,
				success:function (html) {
					$('tbody').html(html);
				}
			});
			$('input:first').keyup(function(){
			var search = $('input:first').val();
			$.ajax({
				type:'POST',
				url:'l_patient_cons_ajax_d.php',
				data:'search='+search,
				success:function (html) {
					$('tbody').html(html);
				}
			});
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