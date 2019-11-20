<?php
include 'connexion.php';
$p=$_POST['p'];
$req=$db->prepare('SELECT pu FROM soins_domicile WHERE id=?');
$req->execute(array($_POST['soins']));
$donnees=$req->fetch(); 
$cout=$donnees['0'];
$req->closeCursor();

$req=$db->prepare('SELECT count(*) FROM soins_domicile_patient WHERE id_soins=? AND id_consultation=?');
$req->execute(array($_POST['soins'],$_POST['consultation'])) or die($req->errorInfo());
$donnees1=$req->fetch(); 
$nbr=$donnees1['0'];
$req->closeCursor();
if ($nbr>0) 
{
	$req=$db->prepare("SELECT  soins_domicile.soins, soins_domicile.pu, soins_domicile_patient.quantite, soins_domicile_patient.montant, soins_domicile.id
		FROM soins_domicile_patient, soins_domicile 
		WHERE soins_domicile_patient.id_soins=soins_domicile.id AND soins_domicile_patient.id_consultation=?");
	$req->execute(array($_POST['consultation']));
	$nbr=$req->rowCount();

	while ($donnees_l_soins=$req->fetch()) 
	{
		echo "<tr>";
			echo "<td>".$donnees_l_soins['0']."</td>";
			echo "<td>".$donnees_l_soins['1']."</td>";
			echo "<td>".$donnees_l_soins['2']."</td>";
			echo "<td>".$donnees_l_soins['3']."</td>";
			if (isset($_POST['p']) AND $_POST['p']=="sd") 
			{
				echo "<td></td>";
			}
			else
			{
				echo "<td><a href='supprim_sd.php?id_cons=".$_POST['consultation']."&amp;id_soins=".$donnees_l_soins['4']."&amp;p=".$p."'><i class='material-icons red-text'>clear</i></a></td>";	
			}
			
		echo "</tr>";		
	}	

	$req=$db->prepare("SELECT SUM(soins_domicile_patient.montant) FROM soins_domicile_patient WHERE id_consultation=?");
	$req->execute(array($_POST['consultation'])) or die($req->errorInfo());
	$donnees=$req->fetch();
		echo '<input type="hidden" name="cout_soins" class="cout" id="cout" value="'.$donnees['0'].'">';
	echo "<tr class='grey'>";
		echo "<td>TOTAL</td>";			
		echo "<td></td>";			
		echo "<td></td>";			
		echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
	echo "</tr>";
		?>
	<script type="text/javascript">
		alert("Soins déja enregistré");
	</script>
	<?php
}
else
{
	$date_soins=date('Y-m-d');
	$cout=$_POST['qt'] * $cout;
	$req=$db->prepare('INSERT INTO `soins_domicile_patient` (`id_soins`, `id_consultation`, `quantite`, `montant`) VALUES (?, ?, ?, ?)');
	$req->execute(array($_POST['soins'],$_POST['consultation'], $_POST['qt'], $cout)) or die($req->errorInfo());
	$req->closeCursor();

	$req=$db->prepare("SELECT  soins_domicile.soins, soins_domicile.pu, soins_domicile_patient.quantite, soins_domicile_patient.montant, soins_domicile.id
		FROM soins_domicile_patient, soins_domicile 
		WHERE soins_domicile_patient.id_soins=soins_domicile.id AND soins_domicile_patient.id_consultation=?");
	$req->execute(array($_POST['consultation']));
	$nbr=$req->rowCount();

	while ($donnees_l_soins=$req->fetch()) 
	{
		echo "<tr>";
			echo "<td>".$donnees_l_soins['0']."</td>";
			echo "<td>".$donnees_l_soins['1']."</td>";
			echo "<td>".$donnees_l_soins['2']."</td>";
			echo "<td>".$donnees_l_soins['3']."</td>";
			if (isset($_POST['p']) AND $_POST['p']=="sd") 
			{
				echo "<td></td>";
			}
			else
			{
				echo "<td><a href='supprim_sd.php?id_cons=".$_POST['consultation']."&amp;id_soins=".$donnees_l_soins['4']."&amp;p=".$p."'><i class='material-icons red-text'>clear</i></a></td>";	
			}
		echo "</tr>";		
	}	

	$req=$db->prepare("SELECT SUM(soins_domicile_patient.montant) FROM soins_domicile_patient WHERE id_consultation=?");
	$req->execute(array($_POST['consultation'])) or die($req->errorInfo());
	$donnees=$req->fetch();
		echo '<input type="hidden" name="cout_soins" class="cout" id="cout" value="'.$donnees['0'].'">';
	echo "<tr class='grey'>";
		echo "<td>TOTAL</td>";			
		echo "<td></td>";			
		echo "<td></td>";			
		echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
	echo "</tr>";
}
?>
