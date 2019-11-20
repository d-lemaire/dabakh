<?php	
session_start();				
include 'connexion.php';
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$search=$_POST['search'];
$bailleur=$_POST['bailleur'];
$nbr=0;
$db->query("SET lc_time_names = 'fr_FR';");
if ($search=="") 
{
	if ($bailleur==0) 
	{
		$reponse=$db->prepare("SELECT mensualite.id, CONCAT(locataire.prenom,' ', locataire.nom), CONCAT(type_logement.type_logement,' à ',logement.adresse), mensualite.montant, mensualite.mois, CONCAT(day(mensualite.date_versement), ' ', monthname(mensualite.date_versement),' ', year(mensualite.date_versement)), CONCAT(bailleur.prenom,' ', bailleur.nom), mensualite.type, location.prix_location, mensualite.id_user  
		FROM `mensualite`,logement, locataire, location, bailleur, type_logement 
		WHERE location.id_locataire=locataire.id AND location.id_logement=logement.id AND type_logement.id = logement.id_type AND location.id=mensualite.id_location AND logement.id_bailleur=bailleur.id AND location.etat='active' AND mensualite.mois=? AND mensualite.annee=?");
		$reponse->execute(array($mois, $annee));
	}
	else
	{
		$reponse=$db->prepare("SELECT mensualite.id, CONCAT(locataire.prenom,' ', locataire.nom), CONCAT(type_logement.type_logement,' à ',logement.adresse), mensualite.montant, mensualite.mois, CONCAT(day(mensualite.date_versement), ' ', monthname(mensualite.date_versement),' ', year(mensualite.date_versement)), CONCAT(bailleur.prenom,' ', bailleur.nom), mensualite.type, location.prix_location, mensualite.id_user   
		FROM `mensualite`,logement, locataire, location, bailleur, type_logement 
		WHERE location.id_locataire=locataire.id AND location.id_logement=logement.id AND type_logement.id = logement.id_type AND location.id=mensualite.id_location AND logement.id_bailleur=bailleur.id AND location.etat='active' AND mensualite.mois=? AND mensualite.annee=? AND bailleur.id=?");
		$reponse->execute(array($mois, $annee, $bailleur));
	}
}
else
{
	if ($bailleur==0) 
	{
		$reponse=$db->prepare("SELECT mensualite.id, CONCAT(locataire.prenom,' ', locataire.nom), CONCAT(type_logement.type_logement,' à ',logement.adresse), mensualite.montant, mensualite.mois, CONCAT(day(mensualite.date_versement), ' ', monthname(mensualite.date_versement),' ', year(mensualite.date_versement)), CONCAT(bailleur.prenom,' ', bailleur.nom), mensualite.type, location.prix_location, mensualite.id_user   
		FROM `mensualite`,logement, locataire, location, bailleur, type_logement 
		WHERE location.id_locataire=locataire.id AND location.id_logement=logement.id AND type_logement.id = logement.id_type AND location.id=mensualite.id_location AND logement.id_bailleur=bailleur.id AND location.etat='active' AND mensualite.mois=? AND mensualite.annee=? AND CONCAT (locataire.prenom,' ',' ',locataire.nom) like CONCAT('%', ?, '%')");
		$reponse->execute(array($mois, $annee, $search));
	}
	else
	{
		$reponse=$db->prepare("SELECT mensualite.id, CONCAT(locataire.prenom,' ', locataire.nom), CONCAT(type_logement.type_logement,' à ',logement.adresse), mensualite.montant, mensualite.mois, CONCAT(day(mensualite.date_versement), ' ', monthname(mensualite.date_versement),' ', year(mensualite.date_versement)), CONCAT(bailleur.prenom,' ', bailleur.nom), mensualite.type, location.prix_location, mensualite.id_user   
	FROM `mensualite`,logement, locataire, location, bailleur, type_logement 
	WHERE location.id_locataire=locataire.id AND location.id_logement=logement.id AND location.id=mensualite.id_location AND logement.id_bailleur=bailleur.id AND type_logement.id = logement.id_type AND location.etat='active' AND mensualite.mois=? AND mensualite.annee=? AND CONCAT (locataire.prenom,' ',' ',locataire.nom) like CONCAT('%', ?, '%') AND bailleur.id=?");
	$reponse->execute(array($mois, $annee, $search, $bailleur));
	}
}

$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$id=$donnees['0'];
		$locataire=$donnees['1'];
		$logement=$donnees['2'];
		$montant=$donnees['3'];
		$mois=$donnees['4'];
		$date_versement=$donnees['5'];
		$bailleur=$donnees['6'];
		$type=$donnees['7'];
		$prix_location=$donnees['8'];
		$id_user=$donnees['9'];
		
		echo "<tr>";
		if ($_SESSION['fonction']=="administrateur" OR $_SESSION['fonction']=="daf") 
		{
			echo "<td><a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_mensualite.php?id=$id'>".$date_versement."</a></td>";
		}
		else
		{
			echo "<td>".$date_versement."</td>";
		}
		
		echo "<td>".$locataire. "</td>";
		echo "<td>".$logement."</td>";
		echo "<td>".$bailleur."</td>";
		echo "<td>".strtoupper($type)."</td>";
		echo "<td>".number_format($prix_location,0,'.',' ')." Fcfa</td>";
		echo "<td>".number_format($montant,0,'.',' ')." Fcfa</td>";
		echo "<td> <a class='btn' href='i_mensualite.php?id=$id'><i class='material-icons left'>print</i>N° $id</a> ";
		if ($_SESSION['fonction']=="administrateur") 
		{
			echo"
		<br><br> <a class='btn red' href='s_mensualite.php?id=$id' onclick='return(confirm(\"Voulez-vous supprimer cette mensualité ?\"))'><i class='material-icons'>close</i>Supprimer</a>";
		}
		
		echo "</td>";
		if ($_SESSION['fonction']=="administrateur") 
		{
		echo "<td>".$id_user."</td>";
			
		}
		echo "</tr>";
		$nbr=$nbr+1;
	}
	/*
	echo "<tr>";
		echo "<td colspan='3'><h5>TOTAL</h5></td>";
		echo "<td><h5>".$nbr."</h5></td>";
	echo "</tr>";
	*/
}
else
{
	echo "<tr><td></td><td></td><td></td><td><h3>Aucun payement ce mois ci </td></tr>";
}			
?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>