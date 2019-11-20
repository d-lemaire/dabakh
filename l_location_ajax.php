<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
$bailleur=$_POST['bailleur'];
$db->query("SET lc_time_names = 'fr_FR';");
if ($search=="")
{
	if ($bailleur==0)
	{
		$reponse=$db->query('SELECT  location.id, logement.designation, logement.adresse, CONCAT(day(location.date_debut)," ",monthname(location.date_debut)," ",year(location.date_debut)), logement.pu, CONCAT(bailleur.prenom," ",bailleur.nom), CONCAT(locataire.prenom," ", locataire.nom), location.caution
			FROM `location`, logement, bailleur, locataire
			WHERE logement.id_bailleur=bailleur.id AND location.id_logement=logement.id AND location.id_locataire=locataire.id AND location.etat="active"
			ORDER BY location.date_debut DESC');
	}
	else
	{
		$reponse=$db->prepare('SELECT  location.id, logement.designation, logement.adresse, CONCAT(day(location.date_debut)," ",monthname(location.date_debut)," ",year(location.date_debut)), logement.pu, CONCAT(bailleur.prenom," ",bailleur.nom), CONCAT(locataire.prenom," ", locataire.nom), location.caution
			FROM `location`, logement, bailleur, locataire
			WHERE logement.id_bailleur=bailleur.id AND location.id_logement=logement.id AND location.id_locataire=locataire.id AND location.etat="active" AND bailleur.id=?
			ORDER BY location.date_debut DESC');
		$reponse->execute(array($bailleur));
	}
}
else
{
	if ($bailleur==0)
	{
		$reponse=$db->prepare('SELECT  location.id, logement.designation, logement.adresse, CONCAT(day(location.date_debut)," ",monthname(location.date_debut)," ",year(location.date_debut)), logement.pu, CONCAT(bailleur.prenom," ",bailleur.nom), CONCAT(locataire.prenom," ", locataire.nom), location.caution
			FROM `location`, logement, bailleur, locataire
			WHERE logement.id_bailleur=bailleur.id AND location.id_logement=logement.id AND location.id_locataire=locataire.id AND location.etat="active" AND CONCAT (locataire.prenom," "," ",locataire.nom) like CONCAT("%", ?, "%")
			ORDER BY location.date_debut DESC');
		$reponse->execute(array($search));
	}
	else
	{
		$reponse=$db->prepare('SELECT  location.id, logement.designation, logement.adresse, CONCAT(day(location.date_debut)," ",monthname(location.date_debut)," ",year(location.date_debut)), logement.pu, CONCAT(bailleur.prenom," ",bailleur.nom), CONCAT(locataire.prenom," ", locataire.nom), location.caution
			FROM `location`, logement, bailleur, locataire
			WHERE logement.id_bailleur=bailleur.id AND location.id_logement=logement.id AND location.id_locataire=locataire.id AND location.etat="active" AND bailleur.id=? AND CONCAT (locataire.prenom," "," ",locataire.nom) like CONCAT("%", ?, "%")
			ORDER BY location.date_debut DESC');
		$reponse->execute(array($bailleur, $search));
	}
}
$resultat=$reponse->rowCount();
while ($donnees= $reponse->fetch())
{
$id=$donnees['0'];
						$designation=$donnees['1'];
						$adresse=$donnees['2'];
$date_debut=$donnees['3'];
$pu=$donnees['4'];
$bailleur=$donnees['5'];
$locataire=$donnees['6'];
				$caution=$donnees['7'];
echo "<tr>";
		//echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_location.php?id=$id'>".$date_debut."</a></td>";
		echo "<td>".$date_debut."</td>";
		echo "<td>".$locataire."</td>";
		echo "<td>".$designation." à ".$adresse."</td>";
		echo "<td>".$bailleur."</td>";
		echo "<td>".number_format($caution,0,'.',' ')." Fcfa</td>";
		echo "<td>".number_format($pu,0,'.',' ')." Fcfa</td>";
		echo "<td>";
		echo "<a target='_blank' class='btn tooltipped' data-position='top' data-delay='50' data-tooltip='Imprimer le contrat de la location' href='i_contrat_location.php?id=$id'><i class='material-icons left'>print</i></a>";
		echo "</td>";
		if ($_SESSION['fonction']=='administrateur')
		{
			echo "<td><a class='red btn' href='desactiver_location.php?id=".$id."' onclick='return(confirm(\"Voulez-vous mettre fin au contrat de location ?\"))'>Désactiver</a>
		</td>";
	}
		
echo "</tr>";}
if ($resultat<1)
{
	echo "<h3 class='center'>Aucun résultat</h3>";
}
?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>