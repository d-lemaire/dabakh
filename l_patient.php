
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
		<title>Liste des patients</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_patient.png);">
		<?php
		include 'verification_menu_sante.php';
		?>
			<h4 class="center col s12 black-text" >Liste des dossiers patient</h4>
			<div class="row">
                <select class="browser-default col s3 m2" name="annee">
                    <?php
                    include 'connexion.php';
                    echo '<option value="all" selected>---Toutes les années---</option>';
                    $reponse=$db->query("SELECT DISTINCT annee_inscription FROM `patient` order by annee_inscription ASC");
                    while ($donnees= $reponse->fetch())
					{
						echo '<option value="'. $donnees['0'] .'" >'. $donnees['0'] .'</option>';
					}
         
               ?>
                </select>
                <a onclick="window.print()" href="" class="btn col s2 offset-s7">Imprimer</a>
            </div>
		<div class="row white">
			<div class="col s4 input-field white">
				<i class="material-icons prefix">search</i>
				<input type="text" name="search" id="search">
				<label for="search">Prénom / Nom</label>
			</div>
			<div class="col s12   ">
				<table class="bordered highlight centered striped">
					<thead>
						<tr style="color: #0d47a1">
							<th  data-field=""></th>
							<th  data-field="">N° dossier</th>
							<th data-field="">Prénom et Nom</th>
							<th data-field="">Date et lieu de naissance</th>
							<th>Profession</th>
							<th>Adresse</th>
							<th data-field="">Téléphone</th>
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
			function l_patient() {
				var search = $('input:first').val();
				var annee = $('select:first').val();
				$.ajax({
					type:'POST',
					url:'l_patient_ajax.php',
					data:'search='+search + '&annee='+annee,
					success:function (html) {
						$('tbody').html(html);
					}
				});
			}
			l_patient();
			$('input:first').keyup(function(){
			l_patient()
				});
			$('select').change(function() {
	         l_patient();
	           
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