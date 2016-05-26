<?php

require ('inc/db.php');
require ('inc/functions.php');

if (!empty($_GET['ses_id'])) {
	$id_session = $_GET['ses_id'];
}
else{
	$id_session = '';
}
$rowCount = 0;
$nbEtuPage = 4;

if (!empty($_GET['nbPage'])) {
	$nbEtuPage = intval($_GET['nbPage']);
}


$currentOffset = 0;
if (array_key_exists('offset', $_GET) && $_GET['offset'] > 0) {
	$currentOffset = intval($_GET['offset']);
}

/*$sql = "SELECT stu_id, stu_email, stu_birthdate AS birthdate, stu_name, stu_firstname, cou_name, cit_name, mar_name, ses_id
		FROM student
		LEFT OUTER JOIN country ON country.cou_id = student.cou_id
		LEFT OUTER JOIN city ON city.cit_id = student.cit_id
		LEFT OUTER JOIN marital_status ON marital_status.mar_id = student.mar_id
		WHERE ses_id = :id_session
		LIMIT :offset, :nbEtuPage"; 
		
$pdoStatement =  $pdo->prepare($sql);
$pdoStatement->bindValue(':id_session', $id_session, PDO::PARAM_INT);
$pdoStatement->bindValue(':nbEtuPage', $nbEtuPage, PDO::PARAM_INT);
$pdoStatement->bindValue(':offset', $currentOffset, PDO::PARAM_INT);

//si erreur
if (!$pdoStatement->execute()) {
	print_r($pdo->errorInfo());
}
else{
	//recuperer toutes les données
	$etudiantListe = $pdoStatement->fetchAll();
}*/

$etudiantListe = getStudentList($id_session, $nbEtuPage, $currentOffset);

/*
$sql2 = "SELECT COUNT(*) AS count
		FROM student
		WHERE ses_id = :idSession";

$pdoStatement2 = $pdo->prepare($sql2);
$pdoStatement2->bindValue(':idSession', $id_session, PDO::PARAM_INT);

if ($pdoStatement2->execute()) {
	$countElem = $pdoStatement2->fetch();
	$nbElemTot = intval($countElem['count']);
}
*/
$nbElemTot = getElementTotList($id_session);
	
require ('inc/list_view.php'); 
?>