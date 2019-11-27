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
include 'connexion.php';
$req=$db->query('SELECT DISTINCT YEAR(date_depense) FROM `depense_bailleur`');
$dateFormat = date("Y-m-d");
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$datefr = $mois[date("n")];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Liste dépenses</title>
		<?php include 'entete.php'; ?>
  
	</head>
	<body id="debut" style="background-image: url(<?=$image ?>l_depense_bailleur.jpg) ;">
		<?php
		include 'verification_menu_immo.php';
		?>
		<br><div class="fixed-action-btn">
	      <a class="btn-floating btn-large brown">
	        <i class="large material-icons">import_export</i>
	      </a>
	      <ul>
	        <li><a href="#debut" class="btn-floating green"><i class="material-icons">arrow_upward</i></a></li>
	        <li><a href="#fin" class="btn-floating red darken-1"><i class="material-icons">arrow_downward</i></a></li>
	      </ul>
	    </div>

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
			<a href="e_depense_bailleur.php" class="btn col s4 offset-s1 ">Nouvelle opération</a>
			<div class="col s4 offset-s2 input-field white" style="border-radius: 45px">
				<i class="material-icons prefix">search</i>
				<input type="text" name="search" id="search">
				<label for="search">Bailleur</label>
			</div>
		</div>
		<div class="row">
			<h4 class="center #0d47a1 col s12" style="color: white">Dépenses effectués pendant le mois de :</h4>
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
							<th>Date</th>
							<th>Bailleur</th>
							<th>Type</th>
							<th>Motif</th>
							<th>Mode versement</th>
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
	
		.table
		{
			background: white;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.tooltipped').tooltip();
			function l_depense_bailleur(mois, annee,search)
			{
				$.ajax({
				type:'POST',
				url:'l_depense_bailleur_ajax.php',
				data:'mois='+mois+'&annee='+annee+'&search='+search,
				success:function (html) {
					$('.tbody').html(html);
				}
			});
			}
			var mois = $('select:eq(1)').val();
			var annee = $('select:eq(0)').val();
			var search = $('input:first').val();
			l_depense_bailleur(mois, annee,search);

			$('select').change(function(){
				var mois = $('select:eq(1)').val();
				var annee = $('select:eq(0)').val();
				var search = $('input:first').val();
				l_depense_bailleur(mois, annee,search);
				});
			$('input:first').keyup(function(){
			var mois = $('select:eq(1)').val();
			var annee = $('select:eq(0)').val();
			var search = $('input:first').val();
			l_depense_bailleur(mois, annee,search);
				});
			$('.fixed-action-btn').floatingActionButton();

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