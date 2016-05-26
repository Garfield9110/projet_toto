<?php

/*
On veut insérer la liste complète des étudiants de la session 2 dans la table student.
On dispose de certaines informations dans le tableau se trouvant dans students_session2.php.
Cependant, des étudiants sont déjà renseignés dans la table student. Il ne faut donc ajouter que les étudiants n'y figurant pas.
Pour savoir si un étudiant est déjà dans la table, on se basera sur le champ "email".
D'ailleurs, pour plus de sécurité, on va ajouter un attribut d'unicité sur ce champ, dans la table student.

Copiez ces 2 fichiers dans un répertoire bacth de votre projet Toto, puis éditez ce fichier pour effectuer les insertions en DB.
*/
require ('../inc/db.php');
require 'students_session2.php';

// $studentsList tableau avec les eleves a ajouté

// A vous de jouer ^^

foreach ($studentsList as $key => $value) {
	$sqlTest = "SELECT stu_email FROM student WHERE stu_email = :email";

	$pdoStatementTest = $pdo->prepare($sqlTest);
	$pdoStatementTest->bindValue(':email', $value['email']);

	if($pdoStatementTest->execute()){
		$testMail = $pdoStatementTest->fetchAll();

		if (sizeof($testMail)>0) {
			echo $value['email']." n'a pas été ajouter a la base de donnée <br/>";
		}
		else{
			$sql = "INSERT INTO student(ses_id, stu_name, stu_firstname, stu_birthdate, stu_email, stu_sex, stu_with_experience, stu_is_leader, stu_inserted) VALUES (:id_session, :nom, :prenom, :dateNaissance, :email, :sexe, :experience, :leader, NOW())";

			$pdoStatement = $pdo->prepare($sql);
			$pdoStatement->bindValue(':id_session', 2, PDO::PARAM_INT);
			$pdoStatement->bindValue(':nom',  $value['name']);
			$pdoStatement->bindValue(':prenom',  $value['firstname']);
			$pdoStatement->bindValue(':dateNaissance',  $value['birthdate']);
			$pdoStatement->bindValue(':email', $value['email']);
			$pdoStatement->bindValue(':sexe', $value['sex']);
			$pdoStatement->bindValue(':experience', $value['with_experience'], PDO::PARAM_INT);
			$pdoStatement->bindValue(':leader', $value['is_leader'], PDO::PARAM_INT);

			if ($pdoStatement->execute()) {
				echo $value['email']." a pas été ajouter a la base de donnée <br/>";
			}
			else{
				//print_r($pdo->errorInfo());
				echo 'Pas executé';
			}
		}
	}
}