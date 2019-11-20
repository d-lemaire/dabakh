<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';
$type=htmlspecialchars($_POST['type']);
$section=htmlspecialchars($_POST['section']);
$motif=htmlspecialchars(strtoupper(suppr_accents($_POST['motif'])));
$montant=htmlspecialchars($_POST['montant']);
$date_operation=htmlspecialchars($_POST['date_operation']);
$pj=htmlspecialchars($_POST['pj']);
$id_user=$_SESSION['prenom']." ".$_SESSION['nom'];

$req=$db->prepare('INSERT INTO caisse_immo(type, section, motif, montant,date_operation, id_user, pj) values (?,?,?,?,?,?,?) ');
$nbr=$req->execute(array($type, $section, $motif, $montant, $date_operation, $id_user, $pj)) or die(print_r($req->errorInfo()));
if ($nbr>0) {
	if ($section=="Approvisionnement banque par caisse") 
	{
		$num_cheque="";
		$type="entree";
		$section="Approvisionnement banque par caisse";
		$motif=strtoupper("Approvisionnement de la banque par la caisse");
		$req=$db->prepare('INSERT INTO banque(type, section, motif, num_cheque, montant,date_operation, structure, id_user) values (?,?,?,?,?,?,?,?) ');
$nbr=$req->execute(array($type, $section, $motif, $num_cheque, $montant, $date_operation, $_SESSION['service'], $id_user)) or die(print_r($req->errorInfo()));
	}
?>
<script type="text/javascript">
	alert('Opération enregistrée');
	window.location="etat_caisse_immo.php";
</script>
<?php
}
else
{
?>
<script type="text/javascript">
	alert('Erreur operation non enregistrée');
	window.location="e_caisse_immo.php";
</script>
<?php
}
?>