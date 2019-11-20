<?php
include 'connexion.php';
include 'supprim_accents.php';
$prenom=htmlspecialchars(strtoupper(suppr_accents($_POST['prenom'])));
$num_dossier=htmlspecialchars($_POST['num_dossier']);
$annee_inscription=htmlspecialchars($_POST['annee_inscription']);
$nom=htmlspecialchars(strtoupper(suppr_accents($_POST['nom'])));
$date_naissance=htmlspecialchars($_POST['date_naissance']);
$telephone=htmlspecialchars($_POST['telephone']);
$situation_matrimoniale=htmlspecialchars($_POST['situation_matrimoniale']);
$sexe=htmlspecialchars($_POST['sexe']);
$lieu_naissance=htmlspecialchars(strtoupper(suppr_accents($_POST['lieu_naissance'])));
$domicile=htmlspecialchars(strtoupper(suppr_accents($_POST['domicile'])));
$profession=htmlspecialchars(strtoupper(suppr_accents($_POST['profession'])));
//$allergie=htmlspecialchars($_POST['allergie']);
//$antecedant=htmlspecialchars($_POST['antecedant']);

$req=$db->prepare('UPDATE patient SET prenom=?, nom=?, date_naissance=?, lieu_naissance=?, telephone=?, domicile=?, profession=?, num_dossier=?, annee_inscription=?, sexe=?, situation_matrimoniale=? WHERE id_patient=?');
$nbr=$req->execute(array($prenom, $nom, $date_naissance, $lieu_naissance, $telephone, $domicile, $profession, $num_dossier, $annee_inscription, $sexe, $situation_matrimoniale, $_GET['id_patient'])) or die(print_r($req->errorInfo()));
if ($nbr>0) {
?>
<script type="text/javascript">
	alert('Dossier modifiée');
	window.location="l_patient.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur dossier non modifiée');
	window.location="list_patient.php";
</script>
<?php
}
?>