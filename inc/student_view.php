<!DOCTYPE html>
<html>
	<head>
		<?php require('inc/header.php') ?>
	</head>
	<body>
	<?php require ('inc/searchForm.php') ?>
			<h3>Page avec les informations de <?= $infoEtudiant['stu_name'] ?> <?= $infoEtudiant['stu_firstname'] ?></h3>
			<ul>
				<li>Nom : <?= $infoEtudiant['stu_name'] ?></li>
				<li>Prenom : <?= $infoEtudiant['stu_firstname'] ?></li>
				<li>Date de naissance : <?= $infoEtudiant['birthdate'] ?></li>
				<li>Email : <?= $infoEtudiant['stu_email'] ?></li>
				<li>Ville : <?= $infoEtudiant['cit_name'] ?></li>
				<li>Nationalité : <?= $infoEtudiant['cou_name'] ?></li>
				<li>Signe du Zodiac : <?= $zodiacFr[$zodiacSign] ?> </li>
			</ul>
		<a href="list.php?ses_id=<?= $infoEtudiant['ses_id'] ?>">Page précédente</a>
		
	</body>
</html>