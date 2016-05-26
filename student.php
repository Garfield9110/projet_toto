<?php

require ('inc/db.php');
require ('inc/functions.php');


if (!empty($_GET['stu_id'])) {
	$id_student = $_GET['stu_id'];
}
else{
	$id_student = '';
} 

require_once __DIR__.'/vendor/autoload.php';

use Whatsma\ZodiacSign;

$calculator = new ZodiacSign\Calculator();

$zodiacFr = array(
	"aries"=>"Belier",
	"taurus"=>"Taureau",
	"gemini"=>"Gemeaux",
	"cancer"=>"Cancer",
	"leo"=>"Lion",
	"virgo"=>"Vierge",
	"libra"=>"Balance",
	"scorpio"=>"Scorpion",
	"sagittarius"=>"Sagitaire",
	"capricorn"=>"Capricorne",
	"aquarius"=>"Verseau",
	"pisces"=>"Poisson",
	);

/*$sql = "SELECT stu_id, stu_email, stu_birthdate AS birthdate, stu_name, stu_firstname, cou_name, cit_name, mar_name, ses_id, MONTH(stu_birthdate) AS mois, DAY(stu_birthdate) AS jour
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
*/

$infoEtudiant = getStudentInfo($id_student);

try {
  $zodiacSign = $calculator->calculate($infoEtudiant['jour'],$infoEtudiant['mois']);
} catch (ZodiacSign\InvalidDayException $e) {
  echo "ERROR: Invalid Day";
} catch (ZodiacSign\InvalidMonthException $e) {
  echo "ERROR: Invalid Month";
}

require ('inc/student_view.php'); 
?>