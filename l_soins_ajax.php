<?php	
session_start();				
include 'connexion.php';
$mois=$_POST['mois'];
$db->query("SET lc_time_names = 'fr_FR';");

$reponse=$db->prepare("SELECT soins.id,CONCAT(CONCAT(patient.prenom,' ', patient.nom), ' née le ',CONCAT(day(patient.date_naissance),' ', monthname(patient.date_naissance),' ', year(patient.date_naissance)), ' à ',patient.lieu_naissance), CONCAT(day(date_soins),' ', monthname(date_soins),' ',year(date_soins)), type, soins 
FROM soins, patient 
WHERE soins.id_patient=patient.id_patient AND month(date_soins)=?
ORDER BY date_soins DESC");
$reponse->execute(array($mois));
$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$id=$donnees['0'];
		$patient=$donnees['1'];
		$date_soins=$donnees['2'];
		$type=$donnees['3'];
		$soins=$donnees['4'];
		echo "<tr>";
			echo "<td><a target='_blank' href='m_soins.php?id=".$id."'>Modifier</a></td>";
			echo "<td> ".$date_soins. "</td>";
			echo "<td>".$patient."</td>";
			echo "<td>".$type."</td>";
			echo "<td>".nl2br($soins)."</td>";
		echo "</tr>";
	}
	
}
else
{
	echo "<tr><td></td><td></td><td></td><td><h3>Aucun soins ce mois ci </td></tr>";
}			
?>