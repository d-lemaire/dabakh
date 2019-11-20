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
$annee= date('Y');
$dateFormat = date("Y-m-d");
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Liste d'attente</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>consultation.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<h3 class="center col s12 black-text" >Liste d'attente</h3>
		<div class="row hide">
			<div class="col s2 white input-field">
				<input type="date" name="date_attente" id="date_attente" value="<?php echo date("Y-m-d");?>" required>
				<label  for="date_attente">Date</label>
			</div>
		</div>
		<div class="row">
			<div class="col s12  ">
				<table class="bordered highlight centered striped">
					<thead>
						<tr style="color: #0d47a1">
							<th  data-field="">Date</th>
							<th  data-field="">N° Dossier</th>
							<th data-field="">Prénom et Nom</th>
							<th data-field="">Date et lieu de naissance</th>
							<th data-field="">Type de consultation</th>
							<th data-field=""></th>
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
			var jour =$('input:first').val();
			$.ajax({
				type:'POST',
				url:'l_attente_ajax.php',
				data:'jour='+jour,
				success:function (html) {
					$('tbody').html(html);
				}
			});
			$('input:first').change(function(){
			var jour = $('input:first').val();
			$.ajax({
				type:'POST',
				url:'l_attente_ajax.php',
				data:'jour='+jour,
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