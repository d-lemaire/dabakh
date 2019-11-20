<?php
session_start();						
include 'connexion.php';
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$db->query("SET lc_time_names = 'fr_FR';");
// recherche de tous les pateients externes pour les associés à leur analyse et ou soins externes
	$reponse=$db->prepare("SELECT  patient_externe.id, CONCAT(patient_externe.prenom,' ',patient_externe.nom), reglement, CONCAT(day(date_analyse),' ', monthname(date_analyse),' ', year(date_analyse))
FROM  patient_externe WHERE month(date_analyse)=? AND year(date_analyse)=? ORDER BY date_analyse DESC");
$reponse->execute(array($_POST['mois'], $_POST['annee']));
$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$id_patient=$donnees['0'];
		$patient_externe=$donnees['1'];
		$reglement=$donnees['2'];
		$date_analyse=$donnees['3'];

		echo "<tr>";
		$total=0;
		if ($_SESSION['fonction']!='secretaire')
		{
			echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_analyse_patient.php?id=$id_patient'>".$date_analyse." </a> </td>";
		}
		else
		{
			echo "<td>".$date_analyse."</td>";
		}
		echo "<td>".$patient_externe."</td>";
		echo "<td>";
		//analyses
			echo "<b ><u>Analyses</u></b><br>";
			$req_analyse=$db->prepare('SELECT analyse.analyse, analyse_patient.montant 
			FROM `analyse_patient`, analyse
			WHERE analyse_patient.id_analyse=analyse.id AND analyse_patient.id_patient=?');
			$req_analyse->execute(array($id_patient));
			while ($donnees_analyse=$req_analyse->fetch()) 
			{
				echo $donnees_analyse['0']."<br>";
				$total=$total+$donnees_analyse['1'];
			}
			//Soins
			echo "<b ><u>Soins externes</u></b><br>";
			$req_soins=$db->prepare('SELECT soins_externes.soins, soins_externes_patient.montant
			FROM  soins_externes,`soins_externes_patient` 
			WHERE soins_externes_patient.id_soins=soins_externes.id AND soins_externes_patient.id_patient=?');
			$req_soins->execute(array($id_patient));
			while ($donnees_soins=$req_soins->fetch()) 
			{
				echo $donnees_soins['0']."<br>";
				$total= $total + $donnees_soins['1'];
			}

		echo "</td>";
		if ($_SESSION['fonction']=='secretaire' OR $_SESSION['fonction']=='administrateur') 
		{
			echo "<td>".number_format($total,0,'.',' ')." Fcfa</td>";
		}
		if ($_SESSION['fonction']=='secretaire')
		{
			if ($reglement=="Non régler") 
			{
				echo "<td> <a href='regler_analyse.php?id=$id_patient&amp;t=$total'> Régler</a> </td>";
			}
			else
			{
				echo "<td>Déjà Régler</td>";
			}
		}
		elseif ($_SESSION['fonction']=='administrateur')
		{
			echo "<td>".$reglement."</td>";
		}
	
		if ($_SESSION['fonction']=='administrateur' or $_SESSION['fonction']=='secretaire')
		{
			
		echo "<td> <a target='_blank' class='btn' href='i_fac_autres_soins.php?id=$id_patient'><i class='material-icons left'>print</i> Facture <b>N°".str_pad($id_patient, 3, "0", 	STR_PAD_LEFT)."</b></a>";

		if ($_SESSION['fonction']=='administrateur') 
		{
			echo"<br> <br><a class='btn red' onclick='return(confirm(\"Voulez-vous effectuer cette suppression ?\"))' href='supp_analyse.php?id=$id_patient'><i class='material-icons left'>close</i></a>";
			;
		}
		echo "</td>";
		
		}

	}
}

else
{
	echo "<tr><td></td><td></td><td></td><td><h3>Aucune enregistrement ce mois</td></tr>";
}			
?>

