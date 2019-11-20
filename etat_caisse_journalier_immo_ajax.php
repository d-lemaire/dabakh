<?php		
session_start();			
include 'connexion.php';
$jour_d=$_POST['jour_d'];
$jour_f=$_POST['jour_f'];
$mois=date("m", strtotime($jour_d));
$annee=date("Y", strtotime($jour_d));


$db->query("SET lc_time_names = 'fr_FR';");
///Solde du jour précédent
	//solde
$reponse=$db->prepare("SELECT SUM(montant) FROM caisse_immo WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation<? AND type='solde'");
$reponse->execute(array($mois, $annee, $jour_d));
$donnees=$reponse->fetch();
$solde=$donnees['0'];
	//entree
$reponse=$db->prepare("SELECT SUM(montant) FROM caisse_immo WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation<? AND type='entree'");
$reponse->execute(array($mois, $annee, $jour_d));
$donnees=$reponse->fetch();
$entree=$donnees['0'];
	//sortie
$reponse=$db->prepare("SELECT SUM(montant) FROM caisse_immo WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation<? AND type='sortie'");
$reponse->execute(array($mois, $annee, $jour_d));
$donnees=$reponse->fetch();
$sortie=$donnees['0'];


$solde_jour_j=$solde+$entree-$sortie;

//Jour précédent
$reponse=$db->prepare("SELECT CONCAT(DATE_FORMAT(MAX(date_operation), '%d'), '/', DATE_FORMAT(MAX(date_operation), '%m'),'/', DATE_FORMAT(MAX(date_operation), '%Y')) 
FROM `caisse_immo`
WHERE date_operation<?");
$reponse->execute(array($jour_d));
$donnees=$reponse->fetch();
$jour_lettre=$donnees['0'];
$reponse->closeCursor();

echo"<tr>";
    echo"<td class=''></td>";    
    echo"<td class=''> Solde du ".$jour_lettre."</td>";
    echo"<td class=''></td>";
    echo"<td class=''></td>";
    echo "<td class='right-align'>".number_format($solde_jour_j,0,'.',' ')." </td>";
echo"<tr>";
    
$req=$db->prepare("SELECT id, CONCAT(DATE_FORMAT(date_operation, '%d'), '/', DATE_FORMAT(date_operation, '%m'),'/', DATE_FORMAT(date_operation, '%Y')), motif, type, montant, section
FROM `caisse_immo`
WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation BETWEEN ? AND ? ORDER BY date_operation, id ASC,  section");
$req->execute(array($mois, $annee, $jour_d, $jour_f));
$nbr=$req->rowCount();
if ($nbr>0) 
{
	$solde=$solde_jour_j;
	$entree=0;
	$sortie=0;
	while ($donnees= $req->fetch())
	{
		$id=$donnees['0'];
		$date_operation=$donnees['1'];
		$motif=$donnees['2'];
        $type=$donnees['3'];
		$montant=$donnees['4'];
		$section=$donnees['5'];
		if ($type=='entree') 
		{
			echo "<tr class='brown lighten-4'>";
		}
		elseif($type=='sortie')
		{
			echo "<tr class=' deep-orange lighten-4'>";
		}
		else
		{
			echo "<tr>";
		}
		echo "<td>". $date_operation. "</td>";
		echo "<td>".$motif."</td>";
		if ($type=="entree") 
		{
			$solde=$solde+$montant;
			$entree=$entree+$montant;		
		echo "<td class='right-align'>".number_format($montant,0,'.',' ')." </td>";
		echo "<td></td>";
		}
		elseif ($type=='sortie') 
		{
			$solde=$solde-$montant;
			$sortie=$sortie+$montant;
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
	}
	$reponse->closeCursor();
	echo "</tr>";
	$req=$db->prepare("SELECT SUM(montant) 
		FROM `caisse_immo` WHERE type='entree' AND month(date_operation)=?");
	$req->execute(array($mois));
	$donnees= $req->fetch();
	$som_entree=$donnees['0'];
	$req->closeCursor();
	$req=$db->prepare('SELECT SUM(montant) 
		FROM `caisse_immo` WHERE type="sortie" AND month(date_operation)=?');
	$req->execute(array($mois));
	$donnees=$req->fetch();
	$som_sortie=$donnees['0'];
	$req->closeCursor();
	$req=$db->prepare('SELECT SUM(montant) 
		FROM `caisse_immo` WHERE type="solde" AND month(date_operation)=?');
	$req->execute(array($mois));
	$donnees=$req->fetch();
	$som_solde=$donnees['0'];
	$req->closeCursor();
	echo "<tr class=''>";
	echo "<td colspan='2' class='trait'><b>TOTAL</b></td>";
	echo "<td class='trait right-align'><b>".number_format($entree,0,'.',' ')." </b></td>";
	echo "<td class='trait right-align'><b>".number_format($sortie,0,'.',' ')." </b></td>";
	echo "<td class='trait right-align'><b>".number_format(($solde),0,'.',' ')." </b></td>";
	echo "</tr>";	
}
else
{
	echo "<tr><td class='trait center' colspan='5'><h3>Aucune opération à cette date </td></tr>";
}			
?>
