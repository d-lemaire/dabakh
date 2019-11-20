<?php
include 'connexion.php';
$req=$db->prepare("DELETE FROM analyse_patient WHERE id=?");
$req->execute(array($_GET['id'])) or die($req->errorInfo());
$id=$_GET['id_pat'];

if ($_GET['p']=="m") 
{
	header("location:m_analyse_patient.php?id=".$id) ;
}
else
{
	header("location:e_analyse1.php?id=".$id) ;	
}
?>
