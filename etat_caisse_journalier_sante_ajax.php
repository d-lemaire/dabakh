<?php		
session_start();			
include 'connexion.php';
$jour_d=$_POST['jour_d'];
$jour_f=$_POST['jour_f'];
$mois=date("m", strtotime($jour_d));
$annee=date("Y", strtotime($jour_d));


$db->query("SET lc_time_names = 'fr_FR';");
//Solde du jour précédent
	//solde
$reponse=$db->prepare("SELECT SUM(montant) FROM caisse_sante WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation<? AND type='solde'");
$reponse->execute(array($mois, $annee, $jour_d));
$donnees=$reponse->fetch();
$solde=$donnees['0'];
	//entree
$reponse=$db->prepare("SELECT SUM(montant) FROM caisse_sante WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation<? AND type='entree'");
$reponse->execute(array($mois, $annee, $jour_d));
$donnees=$reponse->fetch();
$entree=$donnees['0'];
	//sortie
$reponse=$db->prepare("SELECT SUM(montant) FROM caisse_sante WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation<? AND type='sortie'");
$reponse->execute(array($mois, $annee, $jour_d));
$donnees=$reponse->fetch();
$sortie=$donnees['0'];


$solde_jour_j=$solde+$entree-$sortie;

//Jour précédent
$reponse=$db->prepare("SELECT CONCAT(DATE_FORMAT(MAX(date_operation), '%d'), '/', DATE_FORMAT(MAX(date_operation), '%m'),'/', DATE_FORMAT(MAX(date_operation), '%Y')) 
FROM `caisse_sante`
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
    
$req=$db->prepare("SELECT id_operation,  CONCAT(DATE_FORMAT(date_operation, '%d'), '/', DATE_FORMAT(date_operation, '%m'),'/', DATE_FORMAT(date_operation, '%Y')), motif, type, montant, id_consultation,section, id_patient_externe, id_consultation_domicile, id_user, pj
FROM `caisse_sante`
WHERE month(date_operation)=? AND year(date_operation)=? AND date_operation BETWEEN ? AND ? ORDER BY date_operation, id_operation ASC,  section");
$req->execute(array($mois, $annee, $jour_d, $jour_f));
$nbr=$req->rowCount();
if ($nbr>0) 
{
	$solde=$solde_jour_j;
	$entree=0;
	$sortie=0;
	while ($donnees= $req->fetch())
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
		echo "<td>". $date_operation. "</td>";

		//Affichage des pièces jointes
			if (isset($id_consultation)) 
			{
				echo "<td class='center'><a target='_blank' href='i_facture_cons.php?id=".str_pad($id_consultation, 3, "0", STR_PAD_LEFT)."'>N° ".$id_consultation."</a></td>";	
			}
			elseif (isset($id_consultation_domicile)) 
			{
				echo "<td class='center'><a target='_blank' href='i_facture_cons_d.php?id=".$id_consultation_domicile."'>N° ".str_pad($id_consultation_domicile, 3, "0", STR_PAD_LEFT)."</a></td>";	
			}
			elseif (isset($id_patient_externe)) 
			{
				echo "<td class='center'><a target='_blank' href='i_fac_autres_soins.php?id=".$id_patient_externe."'>N° ".str_pad($id_patient_externe, 3, "0", STR_PAD_LEFT)."</a></td>";	
			}
			else
			{
				if ($section<>"solde") 
				{
					echo "<td class='center'>N° ".str_pad($pj, 3, "0", STR_PAD_LEFT)."</td>";
				}
				else
				{
					echo "<td></td>";

				}
			}
		echo "<td>".$motif."</td>";
		if ($type=="entree") 
		{
			$solde=$solde+$montant;
			$entree=$entree+$montant;		
		echo "<td class=right-align>".number_format($montant,0,'.',' ')." </td>";
		echo "<td></td>";
		}
		elseif ($type=='sortie') 
		{
			$solde=$solde-$montant;
			$sortie=$sortie+$montant;
			echo "<td></td>";	
			echo "<td class=right-align>".number_format($montant,0,'.',' ')." </td>";
		}
		else
		{
			$solde=$solde+$montant;
			echo "<td></td>";	
			echo "<td></td>";	
		}
		echo "<td class=right-align>".number_format($solde,0,'.',' ')." </td>";
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
	echo "<tr class=''>";
	echo "<td colspan='3' class='trait'><b>TOTAL</b></td>";
	echo "<td class='trait right-align'><b>".number_format($entree,0,'.',' ')." </b></td>";
	echo "<td class='trait right-align'><b>".number_format($sortie,0,'.',' ')." </b></td>";
	echo "<td class='trait right-align'><b>".number_format(($solde),0,'.',' ')." </b></td>";
	echo "</tr>";	
}
else
{
	echo "<tr><td class='trait'></td><td class='trait'></td><td class='trait'></td><td class='trait'><h3>Aucune opération à cette date </td></tr>";
}			
?>

