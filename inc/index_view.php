<!DOCTYPE html>
<html>
	<head>
		<?php require('inc/header.php') ?>
	</head>
	<body>
	<?php require ('inc/searchForm.php') ?>
		<h3>Session a Esch-Belval</h3>

		<ul>
			<?php foreach ($sessionList as $key => $value) : ?>
				<li><a href="list.php?ses_id=<?= $value['ses_id'] ?>">du <?= $value['ses_opening'] ?> au <?= $value['ses_ending'] ?></a></li>
			<?php endforeach; ?>
		</ul>
		<br/>
		<table>
			<thead>
				<tr>
					<td>Ville</td>
					<td>Nombre d'etudiant de la ville</td>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($statList as $currentStat) : ?>
				<tr>
					<td><a href="search.php?search=<?= $currentStat['Ville'] ?>"><?= $currentStat['Ville'] ?></a></td>
					<td><?= $currentStat['nbEtudiant'] ?></td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
		<br/>
		<a href="add.php">Ajouter un étudiant a une session</a>
	</body>
</html>