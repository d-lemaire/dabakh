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

$db->query("SET lc_time_names = 'fr_FR';");
$reponse=$db->prepare("SELECT CONCAT(patient.prenom,' ',patient.nom), CONCAT(CONCAT(day(patient.date_naissance),' ', monthname(patient.date_naissance),' ', year(patient.date_naissance)), ' ',patient.lieu_naissance), patient.allergie, patient.antecedant, patient.domicile, patient.profession, patient.telephone, patient.situation_matrimoniale, patient.sexe, patient.num_dossier, patient.annee_inscription
FROM `patient` WHERE id_patient=?");
$reponse->execute(array($_GET['id']));
$donnees=$reponse->fetch();
$patient=$donnees['0'];
$date_naissance=$donnees['1'];
$allergie=$donnees['2'];
$antecedant=$donnees['3'];
$domicile=$donnees['4'];
$profession=$donnees['5'];
$telephone=$donnees['6'];
$situation_matrimoniale=$donnees['7'];
$sexe=$donnees['8'];
$num_dossier=$donnees['9'];
$annee_inscription=$donnees['10'];
$num_dossier=str_pad($num_dossier, 3,"0",STR_PAD_LEFT)."/".substr($annee_inscription, -2);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Dossier patient</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>dossier_patient.jpg) ;">
		<a href="" class="btn" onclick="window.close();">Fermer</a>
				<div class="container white" style="border-radius: 15px;">
					<div class="row center"  >
						<img class="col s8 offset-s2" src="../css/images/entete.jpg" >
					</div>
					<div class="row" style="padding: 5px; ">
						<h3 class="col s12 center"><u>Dossier médical <b>N°<?=$num_dossier?></b></u></h3>
						<div class="col s6">
							<div class="row">
								<h6>
								Prénom et Nom : 
								<b>
									<?php if ($sexe=="Masculin") 
											{
												echo "Mr ";
											}
											else
											{
												if ($situation_matrimoniale=="Celibataire") 
												{
													echo "Mlle ";
												}
												else
												{
													echo "Mme ";
												}
											}
									?>
									<?=$patient?>			
								</b><br>
								Profession &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$profession?></b><br>
								Domicile &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$domicile?></b>
								</h6>
							</div>
						</div>
						<div class="col s6">
							<h6>
							Date et lieu de naissance : <b><?=$date_naissance?></b><br>
								Téléphone &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <b><?=$telephone?></b>
							</h6>
						</div>
					</div>
					<!--Liste des consultations -->
					<div class="row" style="padding-bottom: 50px">
						<h5 class="center col s12 white" ><b>
							Consultation(s) éffectuée(s)</b>
						</h5>
						<table class="col s10 white offset-s1" >
							<thead>
								<tr>
									<th style="border: 1px solid">Date consultation</th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$req=$db->prepare("SELECT id_consultation, CONCAT(day(date_consultation),' ', monthname(date_consultation),' ', year(date_consultation))
										FROM `consultation` 
										WHERE consultation.id_patient=? AND etat='medecin' 
										ORDER BY date_consultation DESC");
									$req->execute(array($_GET['id'])) or die(print_r($req->errorInfo()));
									while ($donnees=$req->fetch()) {
										echo "<tr>";
											echo "<td>".$donnees['1']."</td>";
											echo "<td><a target='_blank' href='i_dossier.php?id=".$donnees['0']."'> Détails</a></td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
				</div>
			</div>
	</body>
	<style type="text/css">
		
		/*import du css de materialize*/
		@import "../css/materialize.min.css" print;
		/*CSS pour la page à imprimer */
		/*Dimension de la page*/
		@page
		{
			size: portrait;
			margin: 10px;
			margin: 5px;
		}
		@media print
		{
			.btn, a{
				display: none;
			}
			div
			{
			font: 12pt "times new roman";
			}
		}
		tr td {
			border: 1px solid;
			text-align: center;
			font: 14pt "georgia";

		}
	</style>
</html>