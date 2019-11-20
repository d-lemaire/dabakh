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
if(date("n")==12){
$datefr=1;
$annee=$annee+1;
}
else{
$datefr = $mois[date("n")];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Autres soins du mois</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_analyse.png);">
		<?php
		include 'verification_menu_sante.php';
		?>
        <br>
		
		<div class="row">
			<?php
			if  (($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='infirmier'))
			{
			?>
			<a class="col s4 btn" href="e_analyse.php">Ajouter+</a>
			<?php
			}
			?>
		</div>
		<div class="row">
			<select class="browser-default col s3 m2" name="annee">
				<option value="" disabled>--Choisir Annee--</option>
				<?php
				echo '<option value="2018">'. 2018 .'</option>';
				echo '<option value="2019" selected>'. 2019 .'</option>';
				?>
			</select>
		</div>
		<div class="row">
			<h4 class="center #0d47a1 col s12 m12" style="color: white">Autres soins du mois de</h4>
			<h5><select class="browser-default" name="mois" class="mois" style="width: 170px; margin-left: 600px; height: 40px; background-color: transparent;">
				<?php
				for ($i=1; $i <= 12; $i++) {
					echo "<option value='$i'";
									if ($mois[$i]==$datefr) {
										echo "selected";
									}
					echo">$mois[$i]</option>";
				}
				?>
			</select></h5>
			<div class="col s12   m12">
				<table class="bordered striped highlight centered">
					<thead>
						<tr style="color: #0d47a1">
							<th>Date</th>
							<th>Patient</th>
							<th>Autres soins</th>
							<?php
								if (($_SESSION['fonction']!='infirmier') AND ($_SESSION['fonction']!='medecin')) 
								{
									
									echo "<th>Cout</th>
									<th></th>";
									}
							?>
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
			function analyse(mois, annee)
			{
				$.ajax({
				type:'POST',
				url:'l_analyse_ajax.php',
				data:'mois='+mois+'&annee='+annee,
				success:function (html) {
					$('tbody').html(html);
				}
				});
			}
	var annee = $('select:eq(0)').val();
			var mois = $('select:eq(1)').val();
			analyse(mois, annee);
			$('select').change(function(){
				var annee = $('select:eq(0)').val();
				var mois = $('select:eq(1)').val();
				analyse(mois, annee);
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
			.btn{
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