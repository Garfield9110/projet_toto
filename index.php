<?php 
//Je me connecte a la BD
require ('inc/db.php');
require ('inc/functions.php');
/*$sql = "SELECT ses_id, ses_opening, ses_ending FROM session";

$pdoStatement = $pdo->query($sql);

//si erreur
if ($pdoStatement === false) {
	print_r($pdo->errorInfo());
}
else{
	//recuperer toutes les données
	$sessionList = $pdoStatement->fetchAll();
	//print_r($sessionList);
}*/
$sessionList = getSessionList();
/*
$sql2 = "SELECT city.cit_name AS Ville, COUNT(student.cit_id) AS nbEtudiant
		FROM student
		INNER JOIN city ON city.cit_id = student.cit_id
		GROUP BY city.cit_name";


$pdoStatement2 = $pdo->query($sql2);

//si erreur
if ($pdoStatement2 === false) {
	print_r($pdo->errorInfo());
}
else{
	//recuperer toutes les données
	$statList = $pdoStatement2->fetchAll();
	//print_r($sessionList);
}*/
$statList = getStatList();

//J'affiche ma page
require('inc/index_view.php');
?>
