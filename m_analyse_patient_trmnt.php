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


$req=$db->prepare('UPDATE patient_externe SET prenom=?, nom=?, date_naissance=?, lieu_naissance=?, telephone=?, domicile=?, profession=?, sexe=? WHERE id=?');
$nbr=$req->execute(array($prenom, $nom, $date_naissance, $lieu_naissance, $telephone, $domicile, $profession, $sexe, $_GET['id'])) or die(print_r($req->errorInfo()));
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Autre soins modifiée');
	window.location="l_analyse.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur autres soins non modifiée');
	window.history.go(-1);
</script>
<?php
}
?>