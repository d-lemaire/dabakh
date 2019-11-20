<?php
session_start();
include 'connexion.php';
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$search=$_POST['search'];
if ($search=="")
{
	$reponse=$db->prepare("SELECT depense_bailleur.id, depense_bailleur.type_depense, depense_bailleur.motif, CONCAT(day(depense_bailleur.date_depense), ' ', monthname(depense_bailleur.date_depense),' ', year(depense_bailleur.date_depense)), depense_bailleur.montant, depense_bailleur.type_paiement, CONCAT(bailleur.prenom, ' ', bailleur.nom) 
FROM `depense_bailleur`, bailleur 
WHERE bailleur.id=depense_bailleur.id_bailleur AND depense_bailleur.annee=? AND depense_bailleur.mois=? ORDER BY depense_bailleur.date_depense ASC");
	$reponse->execute(array($annee, $mois));
$resultat=$reponse->rowCount();
}
else
{
	$reponse=$db->prepare("SELECT depense_bailleur.id, depense_bailleur.type_depense, depense_bailleur.motif, CONCAT(day(depense_bailleur.date_depense), ' ', monthname(depense_bailleur.date_depense),' ', year(depense_bailleur.date_depense)), depense_bailleur.montant, depense_bailleur.type_paiement, CONCAT(bailleur.prenom, ' ', bailleur.nom) 
FROM `depense_bailleur`, bailleur 
WHERE bailleur.id=depense_bailleur.id_bailleur AND depense_bailleur.annee=? AND depense_bailleur.mois=? AND CONCAT (bailleur.prenom,' ',' ',bailleur.nom) like CONCAT('%', ?, '%') ORDER BY depense_bailleur.date_depense ASC");
	$reponse->execute(array($annee, $mois, $search));
}
$resultat=$reponse->rowCount();
if ($resultat<1)
{
	echo "<tr><td colspan='7'><h3 class='center'>Aucun résultat</h3></td></tr>";
}
$total=0;
while ($donnees= $reponse->fetch())
{
$id=$donnees['0'];
$type_depense=$donnees['1'];
$motif=$donnees['2'];
$date_depense=$donnees['3'];
$montant=$donnees['4'];
$type_paiement=$donnees['5'];
$bailleur=$donnees['6'];
$total=$total+$montant;
echo "<tr>";
	if ($_SESSION['fonction']=="daf" or $_SESSION['fonction']=="administrateur") 
	{										
		echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_depense_bailleur.php?id=$id'>".$date_depense."</a></td>";
	}
	else
	{
		echo "<td>".$date_depense."</td>";		
	}
	echo "<td>".$bailleur."</td>";
	echo "<td>".strtoupper($type_depense)."</td>";
	echo "<td>".$motif."</td>";
	echo "<td><b>".strtoupper($type_paiement)."</b></td>";
	echo "<td>".number_format($montant,0,'.',' ')." Fcfa</td>";
	if ($_SESSION['fonction']=="administrateur") 
	{
		echo "<td> <a class='red btn' href='s_depense_bailleur.php?id=$id'>Supprimer</a></td>";
	}
echo "</tr>";
}
echo "<tr class='brown lighten-4'>";
	echo "<td colspan='4'><b>TOTAL</b>";
	echo "<td colspan='2'><b>".number_format($total,0,'.',' ')." Fcfa</b>";
echo "</tr>";
?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>