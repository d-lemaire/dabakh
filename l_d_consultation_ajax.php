<?php	
session_start();				
include 'connexion.php';
$mois=$_POST['mois'];
$db->query("SET lc_time_names = 'fr_FR';");

$reponse=$db->prepare("SELECT id_cons,CONCAT(CONCAT(patient.prenom,' ', patient.nom), ' née le ',CONCAT(day(patient.date_naissance),' ', monthname(patient.date_naissance),' ', year(patient.date_naissance)), ' à ',patient.lieu_naissance), CONCAT(day(date_prescription),' ', monthname(date_prescription),' ',year(date_prescription)), renseignements, examen 
FROM `d_consultation`, patient 
WHERE d_consultation.id_patient=patient.id_patient AND month(date_prescription)=?
ORDER BY date_prescription DESC");
$reponse->execute(array($mois));
$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$id_cons=$donnees['0'];
		$patient=$donnees['1'];
		$date_prescription=$donnees['2'];
		$renseignements=$donnees['3'];
		$examen=$donnees['4'];
		echo "<tr>";
		
		echo "<td> ".$date_prescription. "</td>";
		echo "<td>".$patient."</td>";
		echo "<td>".$renseignements."</td>";
		echo "<td>".$examen."</td>";
		echo "<td><a target='_blank' href='d_consultation_trmnt.php?id_cons=".$id_cons."'>Afficher </a></td>";
		echo "</tr>";
	}
	
}
else
{
	echo "<tr><td></td><td></td><td></td><td><h3>Aucune consultation ce mois ci </td></tr>";
}			
?>