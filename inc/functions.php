<?php

function getStudentInfo($id_student){
	global $pdo;
	//$pdo = connectToBd();

	$sql = "SELECT stu_id, stu_email, stu_birthdate AS birthdate, stu_name, stu_firstname, cou_name, cit_name, mar_name, ses_id, MONTH(stu_birthdate) AS mois, DAY(stu_birthdate) AS jour
		FROM student
		LEFT OUTER JOIN country ON country.cou_id = student.cou_id
		LEFT OUTER JOIN city ON city.cit_id = student.cit_id
		LEFT OUTER JOIN marital_status ON marital_status.mar_id = student.mar_id
		WHERE stu_id = :id_student"; 
		
	$pdoStatement =  $pdo->prepare($sql);
	$pdoStatement->bindValue(':id_student' , $id_student, PDO::PARAM_INT);

	//si erreur
	if (!$pdoStatement->execute()) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$infoEtudiant = $pdoStatement->fetch();
	}

	return $infoEtudiant;
}

function getStudentListSearch($search, $search2){
	global $pdo;
	//$pdo = connectToBd();

	$sql = "SELECT stu_id, stu_email, stu_birthdate AS birthdate, stu_name, stu_firstname, cou_name, cit_name, mar_name, ses_id
	FROM student
	LEFT OUTER JOIN country ON country.cou_id = student.cou_id
	LEFT OUTER JOIN city ON city.cit_id = student.cit_id
	LEFT OUTER JOIN marital_status ON marital_status.mar_id = student.mar_id
	WHERE stu_name LIKE :search OR stu_name LIKE :search2 
	OR stu_firstname LIKE :search OR stu_firstname LIKE :search2 
	OR cit_name LIKE :search OR cit_name LIKE :search2 
	OR mar_name LIKE :search OR mar_name LIKE :search2 
	OR stu_email LIKE :search OR stu_email LIKE :search2 ";

	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':search', "%$search%");
	$pdoStatement->bindValue(':search2', "%$search2%");

	if (!$pdoStatement->execute()) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$etudiantListe = $pdoStatement->fetchAll();
		//print_r($etudiantListe);
	}

	return $etudiantListe;
}

function getNbElemTot($search, $search2){
	global $pdo;
	//$pdo = connectToBd();

	$sql2 = "SELECT COUNT(*) AS count
	FROM student
	LEFT OUTER JOIN country ON country.cou_id = student.cou_id
	LEFT OUTER JOIN city ON city.cit_id = student.cit_id
	LEFT OUTER JOIN marital_status ON marital_status.mar_id = student.mar_id
	WHERE stu_name LIKE :search OR stu_name LIKE :search2 
	OR stu_firstname LIKE :search OR stu_firstname LIKE :search2 
	OR cit_name LIKE :search OR cit_name LIKE :search2 
	OR mar_name LIKE :search OR mar_name LIKE :search2 
	OR stu_email LIKE :search OR stu_email LIKE :search2 ";

	$pdoStatement2 = $pdo->prepare($sql2);
	$pdoStatement2->bindValue(':search', "%$search%");
	$pdoStatement2->bindValue(':search2', "%$search2%");

	if ($pdoStatement2->execute()) {
		$countElem = $pdoStatement2->fetch();
		$nbElemTot = intval($countElem['count']);
	}

	return $nbElemTot;
}

function getStudentList($id_session, $nbEtuPage, $currentOffset){
	global $pdo;
	//$pdo = connectToBd();

	$sql = "SELECT stu_id, stu_email, stu_birthdate AS birthdate, stu_name, stu_firstname, cou_name, cit_name, mar_name, ses_id
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
		}

	return $etudiantListe;
}

function getElementTotList($id_session){
	global $pdo;
	//$pdo = connectToBd();

	$sql2 = "SELECT COUNT(*) AS count
			FROM student
			WHERE ses_id = :idSession";

	$pdoStatement2 = $pdo->prepare($sql2);
	$pdoStatement2->bindValue(':idSession', $id_session, PDO::PARAM_INT);

	if ($pdoStatement2->execute()) {
		$countElem = $pdoStatement2->fetch();
		$nbElemTot = intval($countElem['count']);
	}

	return $nbElemTot;
}

function getSessionList(){
	global $pdo;
  	//$pdo = connectToBd();

	$sql = "SELECT ses_id, ses_opening, ses_ending FROM session";

	$pdoStatement = $pdo->query($sql);

	//si erreur
	if ($pdoStatement === false) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$sessionList = $pdoStatement->fetchAll();
		//print_r($sessionList);
	}

	return $sessionList;
}

function getStatList(){
	global $pdo;
	//$pdo = connectToBd();

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
	}

	return $statList;
}

function insertNewStudent($email, $maritalStatus, $villeResidence, $nationalite, $nom, $prenom, $dateNaissance, $email, $idSession){
	global $pdo;
	//$pdo = connectToBd();

	$sqlTest = "SELECT stu_email FROM student WHERE stu_email = :email";

	$pdoStatementTest = $pdo->prepare($sqlTest);
	$pdoStatementTest->bindValue(':email', "$email");

	if($pdoStatementTest->execute()){
		$testMail = $pdoStatementTest->fetchAll();

		if (sizeof($testMail)>0) {
			echo 'Email deja utilisé';
		}
		else{
			$sql2 = "INSERT INTO student(ses_id, mar_id, cit_id, cou_id, stu_name, stu_firstname,stu_birthdate, stu_email, stu_inserted) VALUES (:id_session, :maritalStatus, :villeResidence, :nationalite, :nom, :prenom, :dateNaissance, :email, NOW())";

			$pdoStatement2 = $pdo->prepare($sql2);
			$pdoStatement2->bindValue(':maritalStatus', $maritalStatus);
			$pdoStatement2->bindValue(':villeResidence', $villeResidence);
			$pdoStatement2->bindValue(':nationalite', $nationalite);
			$pdoStatement2->bindValue(':nom', $nom);
			$pdoStatement2->bindValue(':prenom', $prenom);
			$pdoStatement2->bindValue(':dateNaissance', $dateNaissance);
			$pdoStatement2->bindValue(':email', $email);
			$pdoStatement2->bindValue(':id_session', $idSession);

			if ($pdoStatement2->execute()) {
				//echo "L'étudiant a bien été ajouté";
				return true;
			}
			else{
				//print_r($pdo->errorInfo());
				//echo 'Pas executé';
				return false;
			}
		}
	}
}

function deleteStudent($id_student){
	global $pdo;
	//$pdo = connectToBd();

	$sql = "DELETE from student WHERE stu_id = :idStudent"; 
		
		$pdoStatement =  $pdo->prepare($sql);
		$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);

	//si erreur
	if (!$pdoStatement->execute()) {
		print_r($pdo->errorInfo());
		return false;
	}
	else{
		return true;
		//recuperer toutes les données
		//echo "<h3>L'etudiant a bien été supprimer de la base de donnée</h3>";
		//echo "<a href='index.php'>Page précédente</a>";
	}
}

function updateStudentId($id_student, $idSession){
	global $pdo;
	//$pdo = connectToBd();

	$uptSession = "UPDATE student SET ses_id = :idSession, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptSession);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':idSession' , $idSession, PDO::PARAM_INT);
	if ($pdoStatement->execute()){
		//echo 'Session modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentVille($id_student, $villeResidence){
	global $pdo;
	//$pdo = connectToBd();

	$uptVille = "UPDATE student SET cit_id = :idVille, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptVille);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':idVille' , $villeResidence, PDO::PARAM_INT);
	if ($pdoStatement->execute()){
		//echo 'Ville modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentCountry($id_student, $nationalite){
	global $pdo;
	//$pdo = connectToBd();

	$uptPays = "UPDATE student SET cou_id = :idPays, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptPays);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':idPays' , $nationalite, PDO::PARAM_INT);
	if ($pdoStatement->execute()){
		//echo 'Nationalité modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentName($id_student, $nom){
	global $pdo;
	//$pdo = connectToBd();

	$uptNom = "UPDATE student SET stu_name = :nomStu, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptNom);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':nomStu' , $nom);
	if ($pdoStatement->execute()){
		//echo 'Nom modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentFirstName($id_student, $prenom){
	global $pdo;
	//$pdo = connectToBd();

	$uptPrenom = "UPDATE student SET stu_firstname = :prenomStu, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptPrenom);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':prenomStu' , $prenom);
	if ($pdoStatement->execute()){
		//echo 'Prenom modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentBirthDate($id_student, $dateNaissance){
	global $pdo;
	//$pdo = connectToBd();

	$uptAnif = "UPDATE student SET stu_birthdate = :anif, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptAnif);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':anif', $dateNaissance);
	if ($pdoStatement->execute()){
		//echo 'Date de naissance modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentEmail($id_student, $email){
	global $pdo;
	//$pdo = connectToBd();

	$uptMail = "UPDATE student SET stu_email = :mail, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptMail);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':mail' , $email);
	if ($pdoStatement->execute()){
		//echo 'Email modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentSex($id_student, $sexe){
	global $pdo;
	//$pdo = connectToBd();

	$uptSexe = "UPDATE student SET stu_sex = :sexe, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptSexe);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':sexe', $sexe);
	if ($pdoStatement->execute()){
		//echo 'Sexe modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentExperience($id_student, $experience){
	global $pdo;
	//$pdo = connectToBd();

	$uptExp = "UPDATE student SET stu_with_experience = :experience, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptExp);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':experience' , $experience, PDO::PARAM_INT);
	if ($pdoStatement->execute()){
		//echo 'Experience modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentLeader($id_student, $idSession){
	global $pdo;
	//$pdo = connectToBd();

	$uptLeader = "UPDATE student SET stu_is_leader = :leader, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptLeader);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':leader' , $leader, PDO::PARAM_INT);
	if ($pdoStatement->execute()){
		//echo 'Leader modifié <br/>';
		return true;
	}
	return false;
}

function updateStudentMaritalStatus($id_student, $maritalStatus){
	global $pdo;
	//$pdo = connectToBd();

	$uptStatut = "UPDATE student SET mar_id = :maritalStat, stu_updated = NOW() WHERE stu_id = :idStudent";
	$pdoStatement = $pdo->prepare($uptLeader);
	$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
	$pdoStatement->bindValue(':maritalStat' , $maritalStatus);
	if ($pdoStatement->execute()){
		//echo 'Marital statut modifié <br/>';
		return true;
	}
	return false;
}