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

$sql = "SELECT stu_id, stu_email, stu_birthdate AS birthdate, stu_name, stu_firstname, cou_name, cit_name, mar_name
		FROM student
		LEFT OUTER JOIN country ON country.cou_id = student.cou_id
		LEFT OUTER JOIN city ON city.cit_id = student.cit_id
		LEFT OUTER JOIN marital_status ON marital_status.mar_id = student.mar_id";  
$pdoStatement =  $pdo->query($sql);

if ($pdoStatement && $pdoStatement->rowCount() > 0) {
	$etudiantListe = $pdoStatement->fetchAll();
}

$nom = '';
$prenom = '';
$email = '';
$dateNaissance = '';
$villeResidence = '';
$nationalite = '';
$maritalStatus = '';
$idSession = '';

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


	$nomValide = false;
	$prenomValide = false;
	$emailValide = false;
	$dateNaissanceValide = false;
	$villeResidenceValide = false;
	$nationaliteValide = false;
	$maritalStatusValide = false;
	$idSessionValide = false;

	if (empty($nom) || strlen($nom) < 3) {
		echo 'le nom est vide ou trop court <br/>';
	}
	else if (strlen($nom) >= 3) {
		$nomValide = true;
	}

	if (empty($prenom) || strlen($prenom) < 3) {
		echo 'le prenom est vide ou trop court <br/>';
	}
	else if (strlen($prenom) >= 3) {
			$prenomValide = true;
	}

	if (empty($email)) {
		echo 'le mail est vide ou incomplet <br/>';
	}
	else if (strlen($email) > 5) {
			$emailValide = true;
	}

	if (empty($dateNaissance)) {
		echo 'la date de naissance est vide <br/>';
	}
	else{
		$dateNaissanceValide = true;
	}

	if (empty($villeResidence)) {
		echo 'la ville de résidence est vide <br/>';
	}
	else{
		$villeResidenceValide = true;
	}

	if (empty($nationalite)) {
		echo 'la nationalité est vide <br/>';
	}
	else{
		$nationaliteValide = true;
	}

	if (empty($maritalStatus)) {
		echo 'le statut marital est vide <br/>';
	}
	else{
		$maritalStatusValide = true;
	}

	if (empty($idSession)) {
		echo "la session n'a pas été precisé <br/>";
	}
	else{
		$idSessionValide = true;
	}

	if ($nomValide && $prenomValide && $emailValide && $dateNaissanceValide && $villeResidenceValide && $nationaliteValide && $maritalStatusValide && $idSessionValide) {

		$insertOk = insertNewStudent($email, $maritalStatus, $villeResidence, $nationalite, $nom, $prenom, $dateNaissance, $email, $idSession);
		if ($insertOk == true) {
			echo "L'étudiant a bien été ajouté";
		}
		else{
			echo "Pas executé";
		}
		/*$sqlTest = "SELECT stu_email FROM student WHERE stu_email = :email";

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
					echo "L'étudiant a bien été ajouté";
				}
				else{
					//print_r($pdo->errorInfo());
					echo 'Pas executé';
				}
			}
		}
	}*/
	}
}
require ('inc/add_view.php');
?>