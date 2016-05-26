<?php

require ('inc/db.php');
require ('inc/functions.php');

if (!empty($_GET['stu_id'])) {
	$id_student = $_GET['stu_id'];
}
else{
	$id_student = '';
} 

$deleteOk = deleteStudent($id_student);
if ($deleteOk == false) {
	echo "erreure";
}
else{
	echo "<h3>L'etudiant a bien été supprimer de la base de donnée</h3>";
	echo "<a href='index.php'>Page précédente</a>";
}
/*
$sql = "DELETE from student WHERE stu_id = :idStudent"; 
		
		$pdoStatement =  $pdo->prepare($sql);
		$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);

	//si erreur
	if (!$pdoStatement->execute()) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		echo "<h3>L'etudiant a bien été supprimer de la base de donnée</h3>";
		echo "<a href='index.php'>Page précédente</a>";
	}*/
//require ('inc/student_view.php'); 
?>