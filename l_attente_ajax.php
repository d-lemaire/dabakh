<?php	
session_start();				
include 'connexion.php';
$etat="secretaire";
if ($_SESSION['fonction']=="infirmier") 
{
	$etat='secretaire';
}
elseif($_SESSION['fonction']=='medecin' OR $_SESSION['fonction']=='administrateur')
{
	$etat='infirmier';
}

$db->query("SET lc_time_names = 'fr_FR';");
$reponse=$db->prepare('SELECT  CONCAT(patient.prenom," ", patient.nom), CONCAT(day(patient.date_naissance)," ", monthname(patient.date_naissance)," ", year(patient.date_naissance), " à ",patient.lieu_naissance), consultation.id_consultation, patient.id_patient, patient.num_dossier, service.service, patient.annee_inscription, CONCAT(day(consultation.date_consultation)," ", monthname(consultation.date_consultation)," ", year(consultation.date_consultation))
FROM `consultation`, patient, service
WHERE consultation.id_patient=patient.id_patient AND consultation.id_service=service.id AND etat=?');
$reponse->execute(array($etat));
$resultat=$reponse->rowCount();
while ($donnees= $reponse->fetch())
{
	$patient=$donnees['0'];
	$date_naissance=$donnees['1'];
	$id_consultation=$donnees['2'];
	$id_patient=$donnees['3'];
	$num_dossier=$donnees['4'];
	$service=$donnees['5'];
	$annee_inscription=$donnees['6'];
	$date_consultation=$donnees['7'];
	echo "<tr>";
	echo "<td>".$date_consultation."</td>";
	echo "<td>".str_pad($num_dossier, 3,"0",STR_PAD_LEFT)."/".substr($annee_inscription, -2)."</td>";
	echo "<td>".$patient."</td>";
	echo "<td>".$date_naissance."</td>";
	echo "<td>".$service."</td>";
	if ($_SESSION['fonction']!='secretaire') 
	{	
		echo "<td><a class='btn ' href='e_consultation.php?id=".$id_consultation."'>Sélectionner</a></td>";
	}
	
	
	//Annulation d'une consultation
	if ($_SESSION['fonction']!='infirmier' ) 
	{	
		echo "<td><a class='btn red' href='s_consultation.php?id=".$id_consultation."'>Annuler</a></td>";
	}
	
	echo "</tr>";
}
if ($resultat<1)
{
	echo "<tr><td colspan='4'><h3 class='center'>Aucun patient sur la liste d'attente</h3></td></tr>";
}

?>