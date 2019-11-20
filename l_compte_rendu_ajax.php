<?php	
session_start();				
include 'connexion.php';
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$id_personnel=$_POST['id_personnel'];
$db->query("SET lc_time_names = 'fr_FR';");

if ($id_personnel==0) 
{
	$reponse=$db->prepare("SELECT compte_rendu.id, CONCAT(day(compte_rendu.date_redaction),' ',monthname(compte_rendu.date_redaction),' ',year(compte_rendu.date_redaction)), CONCAT(personnel.prenom,' ', personnel.nom)
	FROM `compte_rendu`, personnel 
	WHERE compte_rendu.id_personnel=personnel.id AND month(compte_rendu.date_redaction)=? AND YEAR(compte_rendu.date_redaction)=?
	ORDER BY compte_rendu.date_redaction DESC");
	$reponse->execute(array($mois, $annee));
}
else
{
	$reponse=$db->prepare("SELECT compte_rendu.id, CONCAT(day(compte_rendu.date_redaction),' ',monthname(compte_rendu.date_redaction),' ',year(compte_rendu.date_redaction)), CONCAT(personnel.prenom,' ', personnel.nom)
	FROM `compte_rendu`, personnel 
	WHERE compte_rendu.id_personnel=personnel.id AND month(compte_rendu.date_redaction)=? AND YEAR(compte_rendu.date_redaction)=? AND personnel.id=?
	ORDER BY compte_rendu.date_redaction DESC");
	$reponse->execute(array($mois, $annee, $id_personnel));
}

$nbr=$reponse->rowCount();
if ($nbr>0) 
{
	while ($donnees= $reponse->fetch())
	{
		$id=$donnees['0'];
		$date_redaction=$donnees['1'];
		$personnel=$donnees['2'];
		
		
		echo "<tr>";
		if ($_SESSION['fonction']=="administrateur") 
		{
			echo "<td><a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_compte_rendu.php?id=$id'>".$date_redaction."</a></td>>";
		}
		else
		{
			echo "<td>".$date_redaction."</td>";
		}
			echo "<td>".$personnel."</td>";
		if ($_SESSION['fonction']=="administrateur") 
		{
			echo "<td><a class='tooltipped btn red' data-position='top' data-delay='50' data-tooltip='supprimer' href='s_compte_rendu.php?id=$id' onclick='return(confirm(\"Voulez-vous supprimer ce compte rendu ?\"))'><i class='material-icons left'>close</i></a></td>";
		}
		echo "</tr>";
	}
	
}
else
{
	echo "<tr><td></td><td></td><td><h3>Aucun compte rendu ce mois ci </td></tr>";
}			
?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>