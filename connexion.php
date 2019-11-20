<?php
try {
	$db=new PDO ('mysql:host=localhost;dbname=dabakh;charset=UTF8','root','');
	
} catch (Exception $e) {
	echo "Erreur ".$e->getMessage();
}
?>