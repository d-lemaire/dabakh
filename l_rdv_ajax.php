<?php	
session_start();				
include 'connexion.php';
$mois=$_POST['mois'];
$db->query("SET lc_time_names = 'fr_FR';");
$reponse=$db->prepare("SELECT CONCAT(dayname(date_rdv),' ', day(date_rdv),' ',monthname(date_rdv),' ',year(date_rdv)),CONCAT(hour(heure_rdv),'h : ',minute(heure_rdv)), CONCAT(patient.prenom,' ',patient.nom), CONCAT(day(date_prescription),' ',monthname(date_prescription),' ',year(date_prescription)), CONCAT(CONCAT(day(patient.date_naissance),' ', monthname(patient.date_naissance),' ', year(patient.date_naissance)), ' à ',patient.lieu_naissance), patient.id_patient
FROM `rdv`, patient 
WHERE patient.id_patient=rdv.id_patient AND month(rdv.date_rdv)=?
ORDER BY rdv.date_rdv DESC, rdv.heure_rdv ASC");
$reponse->execute(array($mois));
$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$date_rdv=$donnees['0'];
		$heure_rdv=$donnees['1'];
		$patient=$donnees['2'];
		$date_prescription=$donnees['3'];
		$date_naissance=$donnees['4'];
		$id_patient=$donnees['5'];
		echo "<tr>";
		
		echo "<td> ".$date_rdv. "</td>";
		echo "<td>".$heure_rdv."</td>";
		echo "<td>".$patient." née le ".$date_naissance."</td>";
		echo "<td>".$date_prescription."</td>";
		echo "<td><a class='btn ' href='ajout_file_dattente.php?id_patient=".$id_patient."'>Sélectionner</a></td>";
		echo "</tr>";
	}
	
}
else
{
	echo "<tr><td></td><td></td><td></td><td><h3>Aucun rendez-vous ce mois ci </td></tr>";
}			
?>