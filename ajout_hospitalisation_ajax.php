<?php
include 'connexion.php';
$req=$db->prepare('SELECT cout FROM hospitalisation WHERE id=?');
$req->execute(array($_POST['hospitalisation']));
$donnees=$req->fetch(); 
$pu=$donnees['0'];
$req->closeCursor();

//Vérification de doublons
$req=$db->prepare('SELECT count(*) FROM consultation_hospitalisation WHERE id_consultation=? AND id_hospitalisation=?');
$req->execute(array($_POST['consultation'],$_POST['hospitalisation']));
$donnees1=$req->fetch(); 
$nbr=$donnees1['0'];
$req->closeCursor();

	if ($nbr>0) 
	{
		$req=$db->prepare("SELECT hospitalisation.designation, hospitalisation.cout, consultation_hospitalisation.quantite, consultation_hospitalisation.montant, hospitalisation.id
			FROM `consultation_hospitalisation`, hospitalisation 
			WHERE consultation_hospitalisation.id_hospitalisation=hospitalisation.id AND consultation_hospitalisation.id_consultation=?");
		$req->execute(array($_POST['consultation']));
		$nbr=$req->rowCount();

		while ($donnees_l_hospi=$req->fetch()) 
		{
			echo "<tr>";
				echo "<td>".$donnees_l_hospi['0']."</td>";
				echo "<td>".$donnees_l_hospi['1']."</td>";
				echo "<td>".$donnees_l_hospi['2']."</td>";
				echo "<td>".$donnees_l_hospi['3']."</td>";	
				echo "<td><a href='supprimer_ligne_hospitalisation.php?id_cons=".$_POST['consultation']."&amp;id_hos=".$donnees_l_hospi['4']."'><i class='material-icons red-text'>clear</i></a></td>";
			echo "</tr>";		
		}	

		$req=$db->prepare("SELECT SUM(consultation_hospitalisation.montant) FROM consultation_hospitalisation WHERE id_consultation=?");
		$req->execute(array($_POST['consultation']));
		$donnees=$req->fetch();
			echo '<input type="hidden" name="cout_hospitalisation" class="cout_hospitalisation" id="cout_hospitalisation" value="'.$donnees['0'].'">';
		echo "<tr class='grey'>";
			echo "<td>TOTAL</td>";			
			echo "<td></td>";			
			echo "<td></td>";			
			echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
		echo "</tr>";
			?>
		<script type="text/javascript">
			alert("Hospitalisation déja enregistré");
		</script>
		<?php
	}
	else
	{
		$req=$db->prepare('INSERT INTO consultation_hospitalisation (id_consultation, id_hospitalisation, quantite, montant) VALUES (?,?,?, ?)');
		$req->execute(array($_POST['consultation'], $_POST['hospitalisation'], $_POST['qt'], $_POST['qt'] * $pu)) or die($req->errorInfo());
		$req->closeCursor();

		$req=$db->prepare("SELECT hospitalisation.designation, hospitalisation.cout, consultation_hospitalisation.quantite, consultation_hospitalisation.montant, hospitalisation.id
			FROM `consultation_hospitalisation`, hospitalisation 
			WHERE consultation_hospitalisation.id_hospitalisation=hospitalisation.id AND consultation_hospitalisation.id_consultation=?");
		$req->execute(array($_POST['consultation']));
		$nbr=$req->rowCount();

		while ($donnees_l_hospi=$req->fetch()) 
		{
			echo "<tr>";
				echo "<td>".$donnees_l_hospi['0']."</td>";
				echo "<td>".$donnees_l_hospi['1']."</td>";
				echo "<td>".$donnees_l_hospi['2']."</td>";
				echo "<td>".$donnees_l_hospi['3']."</td>";
				echo "<td><a href='supprimer_ligne_hospitalisation.php?id_cons=".$_POST['consultation']."&amp;id_hos=".$donnees_l_hospi['4']."'><i class='material-icons red-text'>clear</i></a></td>";
			echo "</tr>";		
		}	

		$req=$db->prepare("SELECT SUM(consultation_hospitalisation.montant) FROM consultation_hospitalisation WHERE id_consultation=?");
		$req->execute(array($_POST['consultation']));
		$donnees=$req->fetch();
			echo '<input type="hidden" name="cout_hospitalisation" class="cout_hospitalisation" id="cout_hospitalisation" value="'.$donnees['0'].'">';
		echo "<tr class='grey'>";
			echo "<td>TOTAL</td>";			
			echo "<td></td>";			
			echo "<td></td>";			
			echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
		echo "</tr>";
	}






?>
