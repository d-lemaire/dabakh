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
$datefr = $mois[date("n")];
$req_annee=$db->query('SELECT DISTINCT year(date_pointage) FROM `pointage_personnel`');

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pointages du mois</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_pointage_personnel.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
         <div class="row">
            <select class="browser-default col s4 m2" name="annee">
                <option value="" disabled>--Choisir Annee--</option>
                <?php
                while ($donnee_annee=$req_annee->fetch()) 
                {
                	echo '<option value="'.$donnee_annee['0'] .'"';
                	if ($donnee_annee['0']==$annee) 
                	{
                		echo "selected";
                	}
                	echo '>'.$donnee_annee['0'].'</option>';	
                }
                ?>
            </select>
        </div>
		<div class="row">
			<h4 class="center #0d47a1 col s12" style="color: #0d47a1">Pointages du personnel pour le mois de :</h4>
			<select class="browser-default col s3" name="personnel" >
				<option value=""  selected>--Tout le personnel--</option>
				<?php

				$reponse=$db->query("SELECT * FROM personnel ORDER BY nom ASC");
				while ($donnees=$reponse->fetch()) {
					echo "<option value='".$donnees['0']."'>";
					echo $donnees['2']." ".$donnees['1'];
					echo"</option>";
				}
				$reponse->closeCursor();
				?>
			</select>
			<h5>
			<select class="browser-default col s2 offset-s3" name="mois" class="mois" style="width: 14%;  height: 50px; background-color: transparent;">
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
			<div class="col s12   ">
				<table class="bordered striped highlight centered">
					<thead>
						<tr style="color: #0d47a1">
							<th>Date pointage </th>
							<th>Personnel</th>
							<th>Horaire</th>
							<th>HT</th>
							<th>Remarques/Observations</th>
							<th>Remarques/Observations AD</th>
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
			function pointage_personnel() {
				var personnel = $('select:eq(1)').val();
			    var annee = $('select:eq(0)').val();
	            var mois = $('select:eq(2)').val();
				$.ajax({
					type:'POST',
					url:'list_pointage_personnel_ajax.php',
					data:'mois='+mois+'&personnel='+personnel+'&annee='+annee,
					success:function (html) {
						$('tbody').html(html);
					}
				});	
			};
			pointage_personnel();
			$('select').change(function(){
				pointage_personnel();
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
			button, .btn{
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