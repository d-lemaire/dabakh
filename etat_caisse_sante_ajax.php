<?php		
session_start();			
include 'connexion.php';
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$search=$_POST['search'];
$db->query("SET lc_time_names = 'fr_FR';");

if ($search=="") 
{
	$reponse=$db->prepare("SELECT id_operation,  CONCAT(DATE_FORMAT(date_operation, '%d'), '/', DATE_FORMAT(date_operation, '%m'),'/', DATE_FORMAT(date_operation, '%Y')), motif, type, montant, id_consultation,section, id_patient_externe, id_consultation_domicile, id_user, pj
	FROM `caisse_sante`
	WHERE month(date_operation)=? AND year(date_operation)=? ORDER BY date_operation, id_operation ASC");
	$reponse->execute(array($mois, $annee));
	$nbr=$reponse->rowCount();
	if ($nbr>0) 
	{
		$solde=0;
		while ($donnees= $reponse->fetch())
		{
			$id_caisse=$donnees['0'];
			$date_operation=$donnees['1'];
			$motif=$donnees['2'];
	        $type=$donnees['3'];
			$montant=$donnees['4'];
			$id_consultation=$donnees['5'];
			$section=$donnees['6'];
			$id_patient_externe=$donnees['7'];
			$id_consultation_domicile=$donnees['8'];
			$id_user=$donnees['9'];
			$pj=$donnees['10'];
			if ($type=='entree') 
			{
				echo "<tr class='blue lighten-3'>";		
			}
			elseif($type=='sortie')
			{
				echo "<tr class=' pink accent-1'>";
			}
			else
			{
				echo "<tr>";
			}
			if (($_SESSION['fonction']=='daf') OR ($_SESSION['fonction']=='administrateur') AND ($id_consultation==NULL) AND ($id_patient_externe==NULL) AND ($id_consultation_domicile==NULL) ) {
			echo "<td> <a class='tooltipped white-text' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_caisse_sante.php?id_operation=$id_caisse'> ".$date_operation. "</a> </td>";
			}
			else
			{
				echo "<td>". $date_operation. "</td>";
			}

			if (isset($id_consultation)) 
			{
				echo "<td class='center'><a target='_blank' href='i_facture_cons.php?id=".$id_consultation."'>N° ".$id_consultation."</a></td>";	
			}
			elseif (isset($id_consultation_domicile)) 
			{
				echo "<td class='center'><a target='_blank' href='i_facture_cons_d.php?id=".$id_consultation_domicile."'>N° ".$id_consultation_domicile."</a></td>";	
			}
			elseif (isset($id_patient_externe)) 
			{
				echo "<td class='center'><a target='_blank' href='i_fac_autres_soins.php?id=".$id_patient_externe."'>N° ".$id_patient_externe."</a></td>";	
			}
			else
			{
				if ($section<>"solde") 
				{
					echo "<td>N° ".$pj."</td>";
				}
				else
				{
					echo "<td></td>";

				}
			}

			echo "<td>".$motif."</td>";
			if ($type=="entree") {
				$solde=$solde+$montant;
			echo "<td class='right-align'>".number_format($montant,0,'.',' ')." </td>";
			echo "<td></td>";
			}
			elseif ($type=='sortie') 
			{
				$solde=$solde-$montant;
				echo "<td></td>";	
				echo "<td class='right-align'>".number_format($montant,0,'.',' ')." </td>";
			}
			else
			{
				$solde=$solde+$montant;
				echo "<td></td>";	
				echo "<td></td>";	
			}
				echo "<td class='right-align'>".number_format($solde,0,'.',' ')." </td>";
			if ($_SESSION['fonction']=='administrateur')
			{
				if (isset($id_consultation)) 
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."&amp;id_consultation=$id_consultation' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
				}
				elseif (isset($id_consultation_domicile)) 
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."&amp;id_consultation_domicile=$id_consultation_domicile' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
				}
				elseif (isset($id_patient_externe)) 
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."&amp;id_patient_externe=$id_patient_externe' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
				}
				else
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";
				}
				echo "<td>". $id_user. "</td>";

				
			}
			

		}
		$reponse->closeCursor();
		echo "</tr>";
		$req=$db->prepare("SELECT SUM(montant) 
			FROM `caisse_sante` WHERE type='entree' AND month(date_operation)=?");
		$req->execute(array($mois));
		$donnees= $req->fetch();
		$som_entree=$donnees['0'];
		$req->closeCursor();
		$req=$db->prepare('SELECT SUM(montant) 
			FROM `caisse_sante` WHERE type="sortie" AND month(date_operation)=?');
		$req->execute(array($mois));
		$donnees=$req->fetch();
		$som_sortie=$donnees['0'];
		$req->closeCursor();
		$req=$db->prepare('SELECT SUM(montant) 
			FROM `caisse_sante` WHERE type="solde" AND month(date_operation)=?');
		$req->execute(array($mois));
		$donnees=$req->fetch();
		$som_solde=$donnees['0'];
		$req->closeCursor();
		echo "<tr class='white darken-3 '>";
		echo "<td colspan='3'><b>TOTAL</b></td>";
		echo "<td><b>".number_format($som_entree,0,'.',' ')." </b></td>";
		echo "<td><b>".number_format($som_sortie,0,'.',' ')." </b></td>";
		echo "<td><b>".number_format(($som_solde+$som_entree-$som_sortie),0,'.',' ')." </b></td>";
		echo "</tr>";	
	}
	else
	{
		echo "<tr><td colspan='5' class='center'><h3>Aucune opération ce mois ci </td></tr>";
	}			
}
else
{

	$reponse=$db->prepare("SELECT id_operation, CONCAT(day(date_operation), ' ', monthname(date_operation),' ', year(date_operation)), motif, type, montant, id_consultation,section, id_patient_externe, id_consultation_domicile, id_user
	FROM `caisse_sante`
	WHERE month(date_operation)=? AND year(date_operation)=? AND motif like CONCAT('%',?,'%') ORDER BY date_operation ASC");
	$reponse->execute(array($mois, $annee, $search));
	$nbr=$reponse->rowCount();
	if ($nbr>0) 
	{
		$solde=0;
		while ($donnees= $reponse->fetch())
		{
			$id_caisse=$donnees['0'];
			$date_operation=$donnees['1'];
			$motif=$donnees['2'];
	        $type=$donnees['3'];
			$montant=$donnees['4'];
			$id_consultation=$donnees['5'];
			$section=$donnees['6'];
			$id_patient_externe=$donnees['7'];
			$id_consultation_domicile=$donnees['8'];
			$id_user=$donnees['9'];
			if ($type=='entree') 
			{
				echo "<tr class='blue lighten-3'>";		
			}
			elseif($type=='sortie')
			{
				echo "<tr class=' pink accent-1'>";
			}
			else
			{
				echo "<tr>";
			}
			if (($_SESSION['fonction']=='daf') AND ($id_consultation==NULL) AND ($id_patient_externe==NULL) AND ($id_consultation_domicile==NULL) ) {
			echo "<td> <a class='tooltipped white-text' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_caisse_sante.php?id_operation=$id_caisse'> ".$date_operation. "</a> </td>";
			}
			else
			{
				echo "<td>". $date_operation. "</td>";
			}
			echo "<td>".$motif."</td>";
			if ($type=="entree") {
				$solde=$solde+$montant;
			echo "<td>".number_format($montant,0,'.',' ')." Fcfa</td>";
			echo "<td></td>";
			}
			elseif ($type=='sortie') 
			{
				$solde=$solde-$montant;
				echo "<td></td>";	
				echo "<td>".number_format($montant,0,'.',' ')." Fcfa</td>";
			}
			else
			{
				$solde=$solde+$montant;
				echo "<td></td>";	
				echo "<td></td>";	
			}
				echo "<td>".number_format($solde,0,'.',' ')." Fcfa</td>";
			if ($_SESSION['fonction']=='administrateur')
			{
				if (isset($id_consultation)) 
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."&amp;id_consultation=$id_consultation' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
				}
				elseif (isset($id_consultation_domicile)) 
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."&amp;id_consultation_domicile=$id_consultation_domicile' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
				}
				elseif (isset($id_patient_externe)) 
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."&amp;id_patient_externe=$id_patient_externe' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
				}
				else
				{
					echo "<td><a class='red btn' href='supprimer_ligne_caisse.php?id_caisse_sante=".$id_caisse."' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";
				}
				echo "<td>". $id_user. "</td>";

				
			}
			

		}
		$reponse->closeCursor();
	}
	else
	{
		echo "<tr><td></td><td></td><td></td><td><h3>Aucune opération ce mois ci </td></tr>";
	}			
}
?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>
<style type="text/css">
	td {
    font: 14pt "times new roman";
        
    }
</style>