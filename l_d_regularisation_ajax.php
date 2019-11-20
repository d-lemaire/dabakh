<?php	
session_start();				
include 'connexion.php';
$mois=$_POST['mois'];
$db->query("SET lc_time_names = 'fr_FR';");

$reponse=$db->prepare("SELECT d_regularisation.id_reg, CONCAT(patient.prenom,' ', patient.nom),  CONCAT(day(d_regularisation.date_prescription),' ',monthname(d_regularisation.date_prescription),' ',year(d_regularisation.date_prescription)), CONCAT(day(d_regularisation.date_obs),' ',monthname(d_regularisation.date_obs),' ',year(d_regularisation.date_obs)), CONCAT(day(d_regularisation.date_reg),' ',monthname(d_regularisation.date_reg),' ',year(d_regularisation.date_reg)), d_regularisation.montant, patient.sexe, patient.situation_matrimoniale, d_regularisation.id_cons_domicile
FROM `d_regularisation`, patient 
WHERE patient.id_patient=d_regularisation.id_patient  AND month(date_prescription)=?
ORDER BY date_prescription DESC");
$reponse->execute(array($mois));
$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$id_reg=$donnees['0'];
		$patient=$donnees['1'];
		$date_prescription=$donnees['2'];
		$date_obs=$donnees['3'];
		$date_reg=$donnees['4'];
		$montant=$donnees['5'];
		$id_cons_domicile=$donnees['8'];
		echo "<tr>";
		
		echo "<td> ".$date_prescription. "</td>";
		echo "<td>".$patient."</td>";
		echo "<td>".$date_obs."</td>";
		echo "<td>".$date_reg."</td>";
		echo "<td>".number_format($montant,0,'.',' ')." Fcfa</td>";
		if (!isset($id_cons_domicile)) {
			echo "<td><a target='_blank' href='d_regularisation_trmnt.php?id_reg=".$id_reg."'>Afficher </a></td>";
		}
		else
		{
			echo "<td><a target='_blank' href='d_regularisation_cons_dom_trmnt.php?id_reg=".$id_reg."'>Afficher</a></td>";	
		}
		if ($_SESSION['fonction']=='administrateur') 
		{
			echo "<td><a class='red btn' href='s_d_regularisation.php?id_reg=".$id_reg."'>Supprimer</a></td>";	
			
		}
		echo "</tr>";
	}
	
}
else
{
	echo "<tr><td></td><td></td><td></td><td><h3>Aucune demande ce mois ci </td></tr>";
}			
?>