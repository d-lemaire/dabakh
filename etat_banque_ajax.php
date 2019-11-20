<?php		
session_start();			
include 'connexion.php';
include 'supprim_accents.php';
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$db->query("SET lc_time_names = 'fr_FR';");
$reponse=$db->prepare("SELECT id, CONCAT(day(date_operation), ' ', monthname(date_operation),' ', year(date_operation)), motif, type, montant, section, num_cheque, id_mensualite_bailleur, id_depense_bailleur, id_user, pj
FROM banque
WHERE month(date_operation)=? AND year(date_operation)=? AND structure=? ORDER BY date_operation, id  ASC");
$reponse->execute(array($mois, $annee, $_SESSION['service']));
$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	$solde=0;
	$som_entree=0;
	$som_sortie=0;
	$som_solde=0;
	while ($donnees= $reponse->fetch())
	{
		$id=$donnees['0'];
		$date_operation=$donnees['1'];
		$motif=ucfirst(strtolower(suppr_accents($donnees['2'])));
        $type=$donnees['3'];
		$montant=$donnees['4'];
		$section=$donnees['5'];
		$num_cheque=$donnees['6'];
		$id_mensualite_bailleur=$donnees['7'];
		$id_depense_bailleur=$donnees['8'];
		$id_user=$donnees['9'];
		$pj=$donnees['10'];
		if ($type=='sortie') 
		{
			if ($_SESSION['service']=="immobilier") 
			{
				echo "<tr class='deep-orange lighten-4'>";		
			}
			else
			{
				echo "<tr class='pink accent-1'>";			
			}
		
		}
		elseif ($type=='entree') 
		{
			if ($_SESSION['service']=="immobilier") 
			{
				echo "<tr class='brown lighten-4'>";		
			}
			else
			{
				echo "<tr class='blue lighten-3'>";			
			}
			
		}
		else
		{
			echo "<tr>";	
		}
		if ($_SESSION['fonction']=='daf' or $_SESSION['fonction']=='administrateur') 
		{
			if (isset($id_depense_bailleur)) 
			{
				echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_depense_bailleur.php?id=$id_depense_bailleur'> ".$date_operation. "</a> </td>";
			}
			elseif(isset($id_mensualite_bailleur))
			{
				echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='Impossible de le modifier' > ".$date_operation. "</a> </td>";
			}
			else
			{
				echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_banque.php?id=$id'> ".$date_operation. "</a> </td>";
			}

		}
		else{
			echo "<td class='center'>".$date_operation."</td>";
		}
		
		if (isset($id_mensualite_bailleur)) 
			{
				echo "<td class='center'><a href='i_mensualite_bailleur.php?id=".$id_mensualite_bailleur."' >N° ".$id_mensualite_bailleur."</a></td>";
			}
		elseif (isset($id_depense_bailleur)) 
			{
				echo "<td><a  href='i_depense_bailleur.php?id=".$id_depense_bailleur."' >N° ".$id_depense_bailleur."</a></td>";	
			}
		else
		{
			if ($section<>"solde") 
				{
					echo "<td class='center'>N° ".$pj."</td>";
				}
				else
				{
					echo "<td></td>";

				}
				
		}

		echo "<td>".$num_cheque."</td>";
		echo "<td>".$motif."</td>";
		//calcul du solde
		if ($type=="entree") {
			$som_entree=$som_entree+$montant;
			$solde=$solde+$montant;
		echo "<td class='right-align'>".number_format($montant,0,'.',' ')." </td>";
		echo "<td></td>";
		}
		elseif ($type=='sortie') 
		{
			$som_sortie=$som_sortie+$montant;
			$solde=$solde-$montant;
			echo "<td></td>";	
			echo "<td class='right-align'>".number_format($montant,0,'.',' ')." </td>";
		}
		else
		{
			$som_solde=$som_solde+$montant;
			$solde=$solde+$montant;
			echo "<td></td>";	
			echo "<td></td>";	
		}
			echo "<td class='right-align'>".number_format($solde,0,'.',' ')." </td>";

			if ($_SESSION['fonction']=='administrateur')
			{
				if (isset($id_mensualite_bailleur)) 
					{
						echo "<td><a class='red btn' href='s_mensualite_bailleur.php?id=".$id_mensualite_bailleur."' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";
					}
				elseif (isset($id_depense_bailleur)) 
					{
						echo "<td><a class='red btn' href='s_depense_bailleur.php?id=".$id_depense_bailleur."' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
					}
				else
				{
					echo "<td><a class='red btn' href='supprimer_ligne_bancaire.php?id=".$id."' onclick='return(confirm(\"Voulez-vous supprimer cette opération ?\"))'>Supprimer </a></td>";	
				}
				echo "<td>".$id_user."</td>";
			}

	}
	$reponse->closeCursor();
	//Total et solde
	echo "</tr>";
	
	echo "<tr class='white darken-3 '>";
	echo "<td colspan='4'><b>TOTAL</b></td>";
	echo "<td class='right-align'><b>".number_format($som_entree,0,'.',' ')." </b></td>";
	echo "<td class='right-align'><b>".number_format($som_sortie,0,'.',' ')." </b></td>";
	echo "<td class='right-align'><b>".number_format(($som_solde+$som_entree-$som_sortie),0,'.',' ')." </b></td>";
	echo "</tr>";	
}
else
{
	echo "<tr><td colspan='6' class='center'><h3>Aucune opération ce mois ci </td></tr>";
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