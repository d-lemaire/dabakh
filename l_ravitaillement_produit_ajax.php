<?php	
session_start();				
include 'connexion.php';
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$search=$_POST['search'];
$somme=0;
$db->query("SET lc_time_names = 'fr_FR';");
if ($search=="") 
{
	$reponse=$db->prepare("SELECT ravitaillement_produit.id, CONCAT(day(ravitaillement_produit.date_ravitaillement),' ', monthname(ravitaillement_produit.date_ravitaillement),' ', year(ravitaillement_produit.date_ravitaillement)), produit.produit, produit.pu,ravitaillement_produit.qt, ravitaillement_produit.ancien_qt
FROM ravitaillement_produit, produit 
WHERE produit.id=ravitaillement_produit.id_produit AND month(ravitaillement_produit.date_ravitaillement)=? AND year(ravitaillement_produit.date_ravitaillement)=? ORDER BY ravitaillement_produit.date_ravitaillement DESC");
	$reponse->execute(array($mois, $annee));
}
else
{
	$reponse=$db->prepare("SELECT ravitaillement_produit.id, CONCAT(day(ravitaillement_produit.date_ravitaillement),' ', monthname(ravitaillement_produit.date_ravitaillement),' ', year(ravitaillement_produit.date_ravitaillement)), produit.produit, produit.pu,ravitaillement_produit.qt, ravitaillement_produit.ancien_qt
FROM ravitaillement_produit, produit 
WHERE produit.id=ravitaillement_produit.id_produit AND month(ravitaillement_produit.date_ravitaillement)=? AND year(ravitaillement_produit.date_ravitaillement)=? AND produit.produit like CONCAT('%', ?, '%') ORDER BY ravitaillement_produit.date_ravitaillement DESC");
	$reponse->execute(array($mois, $annee, $search));
}

$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$id=$donnees['0'];
		$date_ravitaillement=$donnees['1'];
		$produit=$donnees['2'];
		$pu=$donnees['3'];
		$qt=$donnees['4'];
		$ancien_qt=$donnees['5'];
		echo "<tr>";
		if ($_SESSION['fonction']=="administrateur")
		{
		echo "<td><a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_ravitaillement_produit.php?id=$id'>".$date_ravitaillement."</a></td>";
		}	
		else
		{
			echo "<td>".$date_ravitaillement. "</td>";
		}	

		echo "<td>".$produit. "</td>";
		echo "<td>".number_format($pu,0,'.',' ')." Fcfa</td>";
		echo "<td>".$ancien_qt."</td>";
		echo "<td>".$qt."</td>";

		if ($_SESSION['fonction']=="administrateur")
		{
			echo "<td> <a class='btn red' href='s_ravitaillement_produit.php?id=$id&amp;a_qt=$ancien_qt' onclick='return(confirm(\"Voulez-vous supprimer ce ravitaillement ?\"))'><i class='material-icons left'>close</i></a></td>";
		} 

		echo "</tr>";
	}
	
}
else
{
	echo "<tr><td></td><td></td><td></td><td><h3>Aucun ravitaillement ce mois ci </td></tr>";
}			
?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>