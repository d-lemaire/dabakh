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
		<?php include 'entete.php';?>
	</head>
	<body style="background-image: url(../css/images/l_patient_rdv.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
			<h3 class="center col s12 black-text" >Choix du patient pour un rendez-vous</h3>
			<div class="row ">
				<div class="col s4 input-field white" style="border-radius:40px;">
				<i class="material-icons prefix black-text">search</i>
				<input type="text" class="black-text" placeholder="Recherche un patient" name="search" id="search">
			</div>
			</div>
			<div class="row">
				<div class="col s10 offset-s1 ">
				<table class="bordered highlight centered striped">
					<thead>
						<tr style="color: #0d47a1">
							<th  data-field=""></th>
							<th  data-field="">N°</th>
							<th data-field="">Prénom</th>
							<th data-field="">Nom</th>
							<th data-field="">Date et lieu de naissance</th>
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
			var search ="";
			$.ajax({
				type:'POST',
				url:'n_patient_rdv_ajax.php',
				data:'search='+search,
				success:function (html) {
					$('tbody').html(html);
				}
			});
			$('input:first').keyup(function(){
			var search = $('input:first').val();
			$.ajax({
				type:'POST',
				url:'n_patient_rdv_ajax.php',
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