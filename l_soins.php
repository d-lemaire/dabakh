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
$dateFormat = date("Y-m-d");
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$datefr = $mois[date("n")];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Soins du mois</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_d_consultation.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="row">
			<div class="col s3">
				<a href="l_patient_soins.php" class="btn cyan">Ajouter +</a>
			</div>
			<h3 class="center #0d47a1 col s12" style="color: white">Liste des soins interne du mois de</h3>
			<h5>
			<div class="row">
				<select class="browser-default col s4 offset-s6" name="mois" class="mois" style="width: 170px; height: 50px; background-color: white	; color: black">
					<?php
					for ($i=1; $i <= 12; $i++) {
						echo "<option value='$i'";
								if ($mois[$i]==$datefr) {
									echo "selected";
								}
						echo">$mois[$i]</option>";
					}
					?>
				</select>
			</div>
			</h5>
			<div class="col s12   ">
				<table class="bordered striped highlight centered">
					<thead>
						<tr style="color: #0d47a1">
							<th></th>
							<th>Date </th>
							<th>Patient</th>
							<th>Type</th>
							<th>Contrôle / Injection</th>
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
			var mois = $('select').val();
			$.ajax({
				type:'POST',
				url:'l_soins_ajax.php',
				data:'mois='+mois,
				success:function (html) {
					$('tbody').html(html);
				}
			});
			$('select').change(function () {
				mois=$('select').val();
				$.ajax({
				type:'POST',
				url:'l_soins_ajax.php',
				data:'mois='+mois,
				success:function (html) {
					$('tbody').html(html);
				}
			});
			})
			
			$('.tooltipped').tooltip();
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
			.btn, a{
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