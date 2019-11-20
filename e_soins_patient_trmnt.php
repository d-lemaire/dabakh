<?php
include 'connexion.php';
include 'supprim_accents.php';
$prenom=htmlspecialchars(strtoupper(suppr_accents($_POST['prenom'])));
$nom=htmlspecialchars(strtoupper(suppr_accents($_POST['nom'])));
$date_naissance=htmlspecialchars($_POST['date_naissance']);
$telephone=htmlspecialchars($_POST['telephone']);
$sexe=htmlspecialchars($_POST['sexe']);
$lieu_naissance=htmlspecialchars(strtoupper(suppr_accents($_POST['lieu_naissance'])));
$domicile=htmlspecialchars(strtoupper(suppr_accents($_POST['domicile'])));
$profession=htmlspecialchars(strtoupper(suppr_accents($_POST['profession'])));


$req=$db->prepare('INSERT INTO patient_externe(prenom, nom, date_naissance, lieu_naissance, telephone, domicile, profession, sexe, reglement) values (?,?,?,?,?,?,?,?,"Non régler") ');
$nbr=$req->execute(array($prenom, $nom, $date_naissance, $lieu_naissance, $telephone, $domicile, $profession, $sexe)) or die(print_r($req->errorInfo()));
if ($nbr>0) {
	$id=$db->lastInsertId();
header('location:e_soins_patient1.php?id='.$id);
}
else
{
?>
<script type="text/javascript">
	alert('Erreur soins non enregistrée');
	window.history.go(-1);
</script>
<?php
}
?>