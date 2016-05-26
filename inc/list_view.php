<!DOCTYPE html>
<html>
	<head>
		<?php require('inc/header.php') ?>
	</head>
	<body>
	<?php require ('inc/searchForm.php') ?>
		<h3>Liste des etudiants</h3>
		<?php if (isset($etudiantListe) && sizeof($etudiantListe) > 0) : ?>
			<table>
				<thead>
					<tr>
						<td>Nom</td>
						<td>Prénom</td>
						<td>Email</td>
						<td>Ville</td>
						<td>Nationalité</td>
						<td>Statut marital</td>
						<td>Date de naissance</td>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($etudiantListe as $currentEtudiant) : ?>
			<form>
				<input type="hidden" name="stu_id" value="<?= $currentEtudiant['stu_id'] ?>" />
				<tr>
					<td><a href="student.php?stu_id=<?= $currentEtudiant['stu_id'] ?>"><?= $currentEtudiant['stu_name'] ?></a></td>
					<td><a href="student.php?stu_id=<?= $currentEtudiant['stu_id'] ?>"><?= $currentEtudiant['stu_firstname'] ?></a></td>
					<td><?= $currentEtudiant['stu_email'] ?></td>
					<td><?= $currentEtudiant['cit_name'] ?></td>
					<td><?= $currentEtudiant['cou_name'] ?></td>
					<td><?= $currentEtudiant['mar_name'] ?></td>
					<td><?= $currentEtudiant['birthdate'] ?></td>
					<td><button formaction="delete.php" type="submit">Supprimer</button></td>
					<td><button formaction="edit.php" type="submit">Modifier</button></td>
				</tr>
				<?php $rowCount++; ?>
			</form>
			<?php endforeach; ?>
				</tbody>
			</table>
		<?php else :?>
			aucun étudiant
		<?php endif; ?>
		<br/>
		<?php if ($rowCount != $nbElemTot):?>
		<form action="list.php?ses_id=<?= $id_session ?>&offset=<?= $currentOffset ?>">
			<input type="hidden" name="ses_id" value="<?= $id_session ?>" />
			<input type="hidden" name="offset" value="<?= $currentOffset ?>" />
			<select name="nbPage">
				<option value="1">1/page</option>
				<option value="2">2/page</option>
				<option value="3">3/page</option>
				<option value="4">4/page</option>
				<option value="5">5/page</option>
			</select>
			<button type="submit">OK</button>
		</form>
		<br/>
	<?php endif;?>
	<?php if($rowCount == 0 || $rowCount == $nbElemTot): ?>
		<br/>
		<a href="index.php">Page précédente</a>
	<?php elseif($rowCount > 0 && $rowCount <= ($nbEtuPage - 1) || ($rowCount + $currentOffset) == $nbElemTot): ?>
		<a href="list.php?ses_id=<?= $id_session?>&offset=<?= $currentOffset - $nbEtuPage ?>&nbPage=<?= $nbEtuPage ?>">Precedent</a>
		<br/>
		<a href="index.php">Page précédente</a>
	<?php elseif ($currentOffset > 0 && $rowCount == $nbEtuPage): ?>
		<a href="list.php?ses_id=<?= $id_session?>&offset=<?= $currentOffset - $nbEtuPage ?>&nbPage=<?= $nbEtuPage ?>">Precedent</a>
		<a href="list.php?ses_id=<?=$id_session ?>&offset=<?= $currentOffset + $nbEtuPage ?>&nbPage=<?= $nbEtuPage ?>">Suivant</a>
		<br/>
		<a href="index.php">Page précédente</a>
	<?php elseif($currentOffset == 0): ?>
		<a href="list.php?ses_id=<?= $id_session ?>&offset=<?= $currentOffset + $nbEtuPage ?>&nbPage=<?= $nbEtuPage ?>">Suivant</a>
		<br/>
		<a href="index.php">Page précédente</a>
	<?php endif; ?>
		
	</body>
</html>