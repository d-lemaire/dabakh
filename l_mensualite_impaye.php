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
$req=$db->query('SELECT DISTINCT YEAR(date_versement) FROM `mensualite` WHERE date_versement IS NOT NULL'); 
$dateFormat = date("Y-m-d");
$req_bailleur=$db->query('SELECT * FROM bailleur ORDER BY nom, prenom');
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$datefr = $mois[date("n")];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Liste mensualités impayé</title>
		<?php include 'entete.php'; ?>
	</head>
	<body id="debut" style="background-image: url(<?=$image ?>banque.jpg) ;">
		<?php
		include 'verification_menu_immo.php';
		?>
		<div class="fixed-action-btn">
	      <a class="btn-floating btn-large brown">
	        <i class="large material-icons">import_export</i>
	      </a>
	      <ul>
	        <li><a href="#debut" class="btn-floating green"><i class="material-icons">arrow_upward</i></a></li>
	        <li><a href="#fin" class="btn-floating red darken-1"><i class="material-icons">arrow_downward</i></a></li>
	      </ul>
	    </div>
		<br>
		<div class="row">
			<select class="browser-default col s3 m2" name="annee">
				<option value="" disabled>--Choisir Annee--</option>
				<?php
				while ($donnee=$req->fetch())
				{
					echo '<option value="'. $donnee['0'] .'">'. $donnee['0'] .'</option>';
				}
				?>
			</select>
			<div class="col s12 m3 offset-m2 input-field white" style="border-radius: 45px">
				<i class="material-icons prefix">search</i>
				<input type="text" name="search" id="search">
				<label for="search">Locataire</label>
			</div>
			<select class="browser-default col s12 m3 offset-m1" name="annee">
				<option value="0" selected="">--Tous les bailleurs--</option>
				<?php
				while ($donnee_bailleur=$req_bailleur->fetch())
				{
					echo '<option value="'. $donnee_bailleur['0'] .'">'. $donnee_bailleur['2'] .' '.$donnee_bailleur['3'].'</option>';
				}
				?>
			</select>
		</div>
		<div class="row">
			<h4 class="center #0d47a1 col s12" style="color: white">Location(s) non réglées pour le mois de :</h4>
			<h5><select class="browser-default col s4" name="mois" class="mois" style="width: 200px; margin-left: 600px; height: 40px; background-color: white;">
				<?php
				for ($i=1; $i <= 12; $i++) {
					echo "<option value='$mois[$i]'";
										if ($mois[$i]==$datefr) {
											echo "selected";
										}
					echo">$mois[$i]</option>";
				}
				?>
			</select></h5>
		</div>
		<div class="row">
			<div class="col s12   ">
				<table class="bordered highlight centered striped table">
					<thead>
						<tr style="color: #0d47a1">
							<th>Locataire</th>
							<th>Logement</th>
							<th>Bailleur</th>
							<th>Montant</th>
						</tr>
					</thead>
					<tbody class="tbody">
					</tbody>
				</table>
			</div>
		</div>
		<span id="fin"></span>
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
		.table
		{
			background: white;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.tooltipped').tooltip();
			$('.fixed-action-btn').floatingActionButton();
			function l_mensualite_impaye()
			{
				var mois = $('select:eq(2)').val();
				var bailleur = $('select:eq(1)').val();
				var annee = $('select:eq(0)').val();
				var search = $('input:first').val();
				$.ajax({
				type:'POST',
				url:'l_mensualite_impaye_ajax.php',
				data:'mois='+mois+'&annee='+annee+'&search='+search+'&bailleur='+bailleur,
				success:function (html) {
					$('.tbody').html(html);
				}
			});
			}
			var mois = $('select:eq(1)').val();
			var annee = $('select:eq(0)').val();
			var search = $('input:first').val();
			l_mensualite_impaye();

			$('select').change(function(){
				l_mensualite_impaye();
				});
			$('input:first').keyup(function(){
			l_mensualite_impaye();
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
			size: landscape;
			margin: 0;
			margin-top: 25px;
		}
		@media print
		{
			.btn,.img{
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