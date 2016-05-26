<?php

require ('inc/db.php');
require ('inc/functions.php');

$etudiantListe = array();
$citiesList = array(
	1 => 'Luxembourg',
	2 => 'Longwy',
	3 => 'Esch-sur-Alzette',
	4 => 'Verdun',
	5 => 'Arlon',
	6 => 'Leudelange',
	7 => 'Pissange',
	8 => 'Metz',
	9 => 'Bruxelles',
	10 => 'Rodange',
	
);
$countriesList = array(
	1 => 'France',
	2 => 'Luxembourg',
	3 => 'Belgique',
	4 => 'Chine',
	5 => 'Allemagne',
);
$maritalStatusList = array(
	1 => 'Célibataire',
	2 => 'Marié(e)',
	3 => 'Divorcé(e)',
	4 => 'Veuf/veuve',
);
$sessionList = array(
	1 => 1,
	2 => 2,
	3 => 3,
);
$sexList = array(
	'M' => 'Monsieur',
	'F' => 'Madamme',
);
$expList = array(
	0 => 'Non',
	1 => 'Oui',
);
$leadList = array(
	0 => 'Non',
	1 => 'Oui',
);


if (!empty($_GET['stu_id'])) {
	$id_student = $_GET['stu_id'];
}
else{
	$id_student = '';
} 

$nom = '';
$prenom = '';
$email = '';
$dateNaissance = '';
$villeResidence = '';
$nationalite = '';
$maritalStatus = '';
$idSession = '';
$sex = '';
$leader = '';
$experience = '';

if (!empty($_POST)) {
	//print_r($_POST); 

	$nom = strtoupper(trim($_POST['studentName']));
	$prenom = trim($_POST['studentFirstname']);
	$email = trim($_POST['studentEmail']);
	$dateNaissance = $_POST['studentBirhtdate'];
	$villeResidence = $_POST['cit_id'];
	$nationalite = $_POST['cou_id'];
	$maritalStatus = $_POST['mar_id'];
	$idSession = $_POST['ses_id'];
	$sexe = $_POST['stu_sex'];
	$experience = $_POST['stu_exp'];
	$leader = $_POST['stu_leader'];


	$nomValide = false;
	$prenomValide = false;
	$emailValide = false;
	$dateNaissanceValide = false;
	$villeResidenceValide = false;
	$nationaliteValide = false;
	$maritalStatusValide = false;
	$idSessionValide = false;
	$sexeValide = false;
	$experienceValide = false;
	$leaderValide = false;

	if (empty($nom)) {
		//echo 'le nom est vide ou trop court <br/>';
	}
	else if (strlen($nom) >= 3) {
		$nomValide = true;
	}

	if (empty($prenom)) {
		//echo 'le prenom est vide ou trop court <br/>';
	}
	else if (strlen($prenom) >= 3) {
			$prenomValide = true;
	}

	if (empty($email)) {
		//echo 'le mail est vide ou incomplet <br/>';
	}
	else if (strlen($email) > 5) {
			$emailValide = true;
	}

	if (empty($dateNaissance)) {
		//echo 'la date de naissance est vide <br/>';
	}
	else{
		$dateNaissanceValide = true;
	}

	if (empty($villeResidence)) {
		//echo 'la ville de résidence est vide <br/>';
	}
	else{
		$villeResidenceValide = true;
	}

	if (empty($nationalite)) {
		//echo 'la nationalité est vide <br/>';
	}
	else{
		$nationaliteValide = true;
	}

	if (empty($maritalStatus)) {
		//echo 'le statut marital est vide <br/>';
	}
	else{
		$maritalStatusValide = true;
	}

	if (empty($idSession)) {
		//echo "la session n'a pas été precisé <br/>";
	}
	else{
		$idSessionValide = true;
	}

	if (empty($sexe)) {
		//echo "le sex n'a pas été precisé <br/>";
	}
	else{
		$sexeValide = true;
	}

	if (empty($experience)) {
		//echo "l'experience n'a pas été precisé <br/>";
	}
	else{
		$experienceValide = true;
	}

	if (empty($leader)) {
		//echo "Leader n'a pas été precisé <br/>";
	}
	else{
		$leaderValide = true;
	}

	if ($nomValide || $prenomValide || $emailValide || $dateNaissanceValide || $villeResidenceValide || $nationaliteValide || $maritalStatusValide || $idSessionValide || $sexeValide || $leaderValide) {

		$sqlTest = "SELECT stu_email FROM student WHERE stu_email = :email";

		$pdoStatementTest = $pdo->prepare($sqlTest);
		$pdoStatementTest->bindValue(':email', "$email");

		if($pdoStatementTest->execute()){
			$testMail = $pdoStatementTest->fetchAll();

			if (sizeof($testMail)>0) {
				echo 'Email deja utilisé';
			}
			else{
				/*$sql = "UPDATE student SET ses_id = :idSession, cit_id = :idVille, cou_id = :idPays, stu_name = :nomStu, stu_firstname = :prenomStu, stu_birthdate = :anif, stu_email = :mail, stu_sex = :sexe, stu_with_experience = :experience, stu_is_leader = :leader, stu_updated = NOW(), mar_id = :maritalStat WHERE stu_id = :idStudent"; 
		
				$pdoStatement =  $pdo->prepare($sql);
				$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
				$pdoStatement->bindValue(':idSession' , $idSession, PDO::PARAM_INT);
				$pdoStatement->bindValue(':idVille' , $villeResidence, PDO::PARAM_INT);
				$pdoStatement->bindValue(':idPays' , $nationalite, PDO::PARAM_INT);
				$pdoStatement->bindValue(':nomStu' , $nom);
				$pdoStatement->bindValue(':maritalStat' , $maritalStatus);
				$pdoStatement->bindValue(':sexe', $sexe);
				$pdoStatement->bindValue(':anif', $dateNaissance);
				$pdoStatement->bindValue(':prenomStu' , $prenom);
				$pdoStatement->bindValue(':mail' , $email);
				$pdoStatement->bindValue(':experience' , $experience, PDO::PARAM_INT);
				$pdoStatement->bindValue(':leader' , $leader, PDO::PARAM_INT);
				if ($pdoStatement->execute()){
					echo 'Elève modifié <br/>';
				}*/


				if($idSessionValide == true){
					$updtOK = updateStudentId($id_student, $idSession);
					if ($updtOK) {
						echo 'Session modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptSession = "UPDATE student SET ses_id = :idSession, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptSession);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':idSession' , $idSession, PDO::PARAM_INT);
					if ($pdoStatement->execute()){
						echo 'Session modifié <br/>';
					}*/
				}

				if ($villeResidenceValide == true) {
					$updtOK = updateStudentVille($id_student, $villeResidence);
					if ($updtOK) {
						echo 'Ville modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptVille = "UPDATE student SET cit_id = :idVille, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptVille);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':idVille' , $villeResidence, PDO::PARAM_INT);
					if ($pdoStatement->execute()){
						echo 'Ville modifié <br/>';
					}*/
				}

				if ($nationaliteValide == true) {
					$updtOK = updateStudentCountry($id_student, $nationalite);
					if ($updtOK) {
						echo 'Nationalité modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptPays = "UPDATE student SET cou_id = :idPays, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptPays);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':idPays' , $nationalite, PDO::PARAM_INT);
					if ($pdoStatement->execute()){
						echo 'Nationalité modifié <br/>';
					}*/
				}

				if ($nomValide == true) {
					$updtOK = updateStudentName($id_student, $nom);
					if ($updtOK) {
						echo 'Nom modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptNom = "UPDATE student SET stu_name = :nomStu, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptNom);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':nomStu' , $nom);
					if ($pdoStatement->execute()){
						echo 'Nom modifié <br/>';
					}*/
				}
				
				if ($prenomValide == true) {
					$updtOK = updateStudentFirstName($id_student, $prenom);
					if ($updtOK) {
						echo 'Prenom modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptPrenom = "UPDATE student SET stu_firstname = :prenomStu, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptPrenom);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':prenomStu' , $prenom);
					if ($pdoStatement->execute()){
						echo 'Prenom modifié <br/>';
					}*/
				}

				if ($dateNaissanceValide == true) {
					$updtOK = updateStudentBirthDate($id_student, $dateNaissance);
					if ($updtOK) {
						echo 'Date de naissance modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptAnif = "UPDATE student SET stu_birthdate = :anif, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptAnif);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':anif', $dateNaissance);
					if ($pdoStatement->execute()){
						echo 'Date de naissance modifié <br/>';
					}*/
				}

				if ($emailValide == true) {
					$updtOK = updateStudentEmail($id_student, $email);
					if ($updtOK) {
						echo 'Email modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptMail = "UPDATE student SET stu_email = :mail, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptMail);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':mail' , $email);
					if ($pdoStatement->execute()){
						echo 'Email modifié <br/>';
					}*/
				}

				if ($sexeValide == true) {
					$updtOK = updateStudentSex($id_student, $sexe);
					if ($updtOK) {
						echo 'Sexe modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptSexe = "UPDATE student SET stu_sex = :sexe, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptSexe);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':sexe', $sexe);
					if ($pdoStatement->execute()){
						echo 'Sexe modifié <br/>';
					}*/
				}

				if ($experienceValide == true) {
					$updtOK = updateStudentExperience($id_student, $experience);
					if ($updtOK) {
						echo 'Experience modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptExp = "UPDATE student SET stu_with_experience = :experience, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptExp);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':experience' , $experience, PDO::PARAM_INT);
					if ($pdoStatement->execute()){
						echo 'Experience modifié <br/>';
					}*/
				}

				if ($leaderValide == true) {
					$updtOK = updateStudentLeader($id_student, $idSession);
					if ($updtOK) {
						echo 'Leader modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptLeader = "UPDATE student SET stu_is_leader = :leader, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptLeader);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':leader' , $leader, PDO::PARAM_INT);
					if ($pdoStatement->execute()){
						echo 'Leader modifié <br/>';
					}*/
				}

				if ($maritalStatusValide == true) {
					$updtOK = updateStudentMaritalStatus($id_student, $maritalStatus);
					if ($updtOK) {
						echo 'Marital statut modifié <br/>';
					}
					else{
						echo "erreur";
					}
					/*$uptStatut = "UPDATE student SET mar_id = :maritalStat, stu_updated = NOW() WHERE stu_id = :idStudent";
					$pdoStatement = $pdo->prepare($uptLeader);
					$pdoStatement->bindValue(':idStudent' , $id_student, PDO::PARAM_INT);
					$pdoStatement->bindValue(':maritalStat' , $maritalStatus);
					if ($pdoStatement->execute()){
						echo 'Marital statut modifié <br/>';
					}*/
				}

				
				//si erreur
				/*if (!$pdoStatement->execute()) {
					print_r($pdo->errorInfo());
				}
				else{
					echo "L'etudiant a bien été modifié";
				}*/
			}
		}
	}
}
require ('inc/edit_view.php');
?>