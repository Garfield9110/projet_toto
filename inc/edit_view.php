<html>
<head>
	<title>Gestion des &Eacute;tudiants</title>
	<style type="text/css">
	HTML, BODY {
		font-family: Tahoma, Verdana, sans-serif;
	}
	form{
		width: 150px;
	}
	</style>
</head>
<body>
	<form action="edit.php?stu_id=<?= $_GET['stu_id'] ?>" method="post">
		<fieldset>
			<legend>Modifier l'etudiant</legend>
			<input type="text" name="studentName" value="" placeholder="Nom"><br />
			<input type="text" name="studentFirstname" value="" placeholder="Prénom"><br />
			<input type="email" name="studentEmail" value="" placeholder="E-mail"><br />
			<input type="date" name="studentBirhtdate" value="" placeholder="Date de naissance (aaaa-mm-jj)"><br />
			Ville de résidence :<br />
			<select name="cit_id">
				<option value="0">choisissez :</option>
				<?php foreach ($citiesList as $key=>$value) :?>
				<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select><br />
			Nationalité :<br />
			<select name="cou_id">
				<option value="0">choisissez :</option>
				<?php foreach ($countriesList as $key=>$value) :?>
				<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select><br />
			n° Session :<br />
			<select name="ses_id">
				<option value="0">choisissez :</option>
				<?php foreach ($sessionList as $key=>$value) :?>
				<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select><br />
			Statut marital :<br />
			<select name="mar_id">
				<option value="0">choisissez :</option>
				<?php foreach ($maritalStatusList as $key=>$value) :?>
				<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select><br />
			Sexe :<br />
			<select name="stu_sex">
				<option value="0">choisissez :</option>
				<?php foreach ($sexList as $key=>$value) :?>
				<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select><br />
			Experience :<br />
			<select name="stu_exp">
				<option value="0">choisissez :</option>
				<?php foreach ($expList as $key=>$value) :?>
				<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select><br />
			Leader :<br />
			<select name="stu_leader">
				<option value="0">choisissez :</option>
				<?php foreach ($leadList as $key=>$value) :?>
				<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select><br />
			<input type="submit" value="Valider"><br />
		</fieldset>
	</form>
	<br/>
	<a href="index.php">Page précédente</a>
</body>
</html>